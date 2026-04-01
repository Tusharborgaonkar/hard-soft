<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    public function index()
    {
        $sections = \App\Models\Section::where('is_active', true)
            ->with(['questions' => function ($query) {
            $query->where('is_active', true)->with('options')->orderBy('order');
        }])
            ->orderBy('order')
            ->get();

        return view('gujarati_form', compact('sections'));
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $response = \App\Models\Response::create([
                'user_identifier' => $request->ip(),
                'meta_data' => ['user_agent' => $request->userAgent()],
            ]);

            // Separate reasons from primary answers
            $reasons = [];
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'q_') && str_ends_with($key, '_reason')) {
                    $qId = str_replace(['q_', '_reason'], '', $key);
                    $reasons[$qId] = $value;
                }
            }

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'q_') && !str_ends_with($key, '_reason')) {
                    $questionId = str_replace('q_', '', $key);
                    $answerText = is_array($value) ? json_encode($value) : $value;
                    $reasonText = $reasons[$questionId] ?? null;

                    if (($answerText !== null && $answerText !== '') || ($reasonText !== null && $reasonText !== '')) {
                        \App\Models\Answer::create([
                            'response_id' => $response->id,
                            'question_id' => (int)$questionId,
                            'answer_value' => $answerText ?? '',
                            'reason' => $reasonText,
                        ]);
                    }
                }
            }

            return response()->json(['success' => true]);
        });
    }
}
