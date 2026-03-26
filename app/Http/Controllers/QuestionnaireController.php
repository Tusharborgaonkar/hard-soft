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

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'q_')) {
                    $questionId = str_replace('q_', '', $key);
                    $answerText = is_array($value) ? json_encode($value) : $value;

                    if ($answerText !== null && $answerText !== '') {
                        \App\Models\Answer::create([
                            'response_id' => $response->id,
                            'question_id' => (int)$questionId,
                            'answer_text' => $answerText,
                        ]);
                    }
                }
            }

            return response()->json(['success' => true]);
        });
    }
}
