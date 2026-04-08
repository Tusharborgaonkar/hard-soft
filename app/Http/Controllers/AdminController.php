<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_responses' => Response::count(),
            'total_questions' => Question::count(),
            'active_questions' => Question::where('is_active', true)->count(),
            'recent_responses' => Response::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function questions()
    {
        $questions = Question::with(['options', 'section'])
            ->get()
            ->sortBy([
                ['section.order', 'asc'],
                ['order', 'asc'],
            ]);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $sections = \App\Models\Section::orderBy('order')->get();
        return view('admin.questions.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'question_text_gu' => 'required',
            'type' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            Log::info('Storing options:', ['options' => $request->options]);
            $data = $request->only([
                'section_id',
                'question_text_gu', 'question_text_en',
                'type'
            ]);
            $data['is_required'] = $request->has('is_required');
            $data['meta_params'] = $request->input('meta_params', null);
            $data['order'] = Question::where('section_id', $request->section_id)->max('order') + 1;

            $question = Question::create($data);

            if ($request->has('options')) {
                foreach ($request->options as $index => $opt) {
                    $gu = trim($opt['gu'] ?? '');
                    if ($gu !== '') {
                        $question->options()->create([
                            'option_text_gu' => $gu,
                            'option_text_en' => trim($opt['en'] ?? ''),
                            'order' => (int)($opt['order'] ?? $index),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.questions')->with('success', 'Question created successfully!');
    }

    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $sections = \App\Models\Section::orderBy('order')->get();
        return view('admin.questions.edit', compact('question', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'question_text_gu' => 'required',
            'type' => 'required',
        ]);

        DB::transaction(function () use ($request, $question) {
            Log::info('Updating options:', ['options' => $request->options]);
            $data = $request->only([
                'section_id',
                'question_text_gu', 'question_text_en',
                'type'
            ]);
            $data['is_required'] = $request->has('is_required');
            $data['meta_params'] = $request->input('meta_params', null);

            $question->update($data);

            if ($request->has('options')) {
                $submittedIds = [];
                foreach ($request->options as $index => $opt) {
                    $gu = trim($opt['gu'] ?? '');
                    if ($gu !== '') {
                        if (isset($opt['id'])) {
                            // Update existing
                            $option = $question->options()->find($opt['id']);
                            if ($option) {
                                $option->update([
                                    'option_text_gu' => $gu,
                                    'option_text_en' => trim($opt['en'] ?? ''),
                                    'order' => (int)($opt['order'] ?? $index),
                                ]);
                                $submittedIds[] = $option->id;
                            } else {
                                $newOpt = $question->options()->create([
                                    'option_text_gu' => $gu,
                                    'option_text_en' => trim($opt['en'] ?? ''),
                                    'order' => (int)($opt['order'] ?? $index),
                                ]);
                                $submittedIds[] = $newOpt->id;
                            }
                        } else {
                            $newOpt = $question->options()->create([
                                'option_text_gu' => $gu,
                                'option_text_en' => trim($opt['en'] ?? ''),
                                'order' => (int)($opt['order'] ?? $index),
                            ]);
                            $submittedIds[] = $newOpt->id;
                        }
                    }
                }
                $question->options()->whereNotIn('id', $submittedIds)->delete();
            } else {
                $question->options()->delete();
            }
        });

        return redirect()->route('admin.questions')->with('success', 'Question updated successfully!');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete(); // Cascades to options if FK is set, or we do it manually
        return redirect()->route('admin.questions')->with('success', 'Question deleted successfully!');
    }

    public function toggleQuestion($id)
    {
        $q = Question::findOrFail($id);
        $q->is_active = !$q->is_active;
        $q->save();
        return back()->with('success', 'Status updated!');
    }

    public function reorderQuestions(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $index => $id) {
            Question::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function responses()
    {
        $responses = Response::withCount('answers')
            ->orderByRaw('CAST(response_number AS UNSIGNED) ASC')
            ->paginate(20);
        return view('admin.responses.index', compact('responses'));
    }

    public function showResponse($id)
    {
        $response = Response::with(['answers.question.options'])->findOrFail($id);
        return view('admin.responses.show', compact('response'));
    }

    public function editResponse($id)
    {
        $response = Response::with(['answers.question'])->findOrFail($id);
        $sections = \App\Models\Section::where('is_active', true)
            ->with(['questions' => function ($query) {
            $query->where('is_active', true)->with('options')->orderBy('order');
        }])
            ->orderBy('order')
            ->get();

        $editData = [];
        foreach ($response->answers as $ans) {
            if (!$ans->question) continue;
            
            $val = $ans->answer_value;
            $decoded = json_decode($val, true);
            if (is_array($decoded)) {
                $editData['q_' . $ans->question_id] = $decoded;
            }
            else {
                $editData['q_' . $ans->question_id] = $val;
            }
        }

        $editMode = true;

        return view('gujarati_form', compact('sections', 'response', 'editData', 'editMode'));
    }

    public function updateResponse(Request $request, $id)
    {
        $request->validate([
            'response_number' => 'required|numeric|unique:responses,response_number,' . $id
        ]);

        return DB::transaction(function () use ($request, $id) {
            $response = Response::findOrFail($id);
            
            // Allow updating the manual response number
            $response->update(['response_number' => $request->input('response_number')]);

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'q_')) {
                    $qIdString = str_replace('q_', '', $key);
                    $questionId = (int) preg_replace('/[^0-9]/', '', $qIdString);
                    
                    if ($questionId <= 0) continue;

                    $answerText = is_array($value) ? json_encode($value) : $value;

                    if ($answerText !== null && $answerText !== '') {
                        Answer::updateOrCreate(
                            ['response_id' => $response->id, 'question_id' => $questionId],
                            ['answer_value' => (string) $answerText]
                        );
                    }
                    else {
                        Answer::where('response_id', $response->id)->where('question_id', $questionId)->delete();
                    }
                }
            }

            return response()->json(['success' => true]);
        });
    }
    public function destroyResponse($id)
    {
        $response = Response::findOrFail($id);
        $response->delete();
        return redirect()->route('admin.responses')->with('success', 'Response deleted successfully (Soft Deleted)');
    }
}
