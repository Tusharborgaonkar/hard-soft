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
        $request->validate([
            'response_number' => 'required|numeric|unique:responses,response_number'
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $response = \App\Models\Response::create([
                    'user_identifier' => $request->ip(),
                    'response_number' => $request->input('response_number'),
                ]);

                foreach ($request->all() as $key => $value) {
                    if (str_starts_with($key, 'q_')) {
                        $qIdString = str_replace('q_', '', $key);
                        $questionId = (int)preg_replace('/[^0-9]/', '', $qIdString);

                        if ($questionId <= 0)
                            continue;

                        $answerText = is_array($value) ? json_encode($value) : $value;

                        if ($answerText !== null && $answerText !== '') {
                            \App\Models\Answer::create([
                                'response_id' => $response->id,
                                'question_id' => $questionId,
                                'answer_value' => (string)$answerText,
                            ]);
                        }
                    }
                }

                return response()->json(['success' => true]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database Error: ' . $e->getMessage()
            ], 500);
        }
    }

}
