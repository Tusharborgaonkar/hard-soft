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
            ->sortBy(function($q) {
                return ($q->section->order ?? 0) . '-' . $q->order;
            });
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
                'type', 'is_required', 'meta_params'
            ]);
            $data['order'] = Question::where('section_id', $request->section_id)->max('order') + 1;
            
            $question = Question::create($data);

            if ($request->has('options')) {
                foreach ($request->options as $opt) {
                    $gu = trim($opt['gu'] ?? '');
                    if ($gu !== '') {
                        $question->options()->create([
                            'option_text_gu' => $gu,
                            'option_text_en' => trim($opt['en'] ?? ''),
                            'order' => (int)($opt['order'] ?? 0),
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
                'type', 'is_required', 'meta_params'
            ]);
            
            $question->update($data);

            $question->options()->delete();
            
            if ($request->has('options')) {
                foreach ($request->options as $opt) {
                    $gu = trim($opt['gu'] ?? '');
                    if ($gu !== '') {
                        $question->options()->create([
                            'option_text_gu' => $gu,
                            'option_text_en' => trim($opt['en'] ?? ''),
                            'order' => (int)($opt['order'] ?? 0),
                        ]);
                    }
                }
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
        $responses = Response::withCount('answers')->latest()->paginate(20);
        return view('admin.responses.index', compact('responses'));
    }

    public function showResponse($id)
    {
        $response = Response::with(['answers.question'])->findOrFail($id);
        return view('admin.responses.show', compact('response'));
    }
}
