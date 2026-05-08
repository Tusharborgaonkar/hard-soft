<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultReportController extends Controller
{
    public function index()
    {
        // 1. Fetch all responses with their answers
        $responses = Response::with('answers')->get();
        
        // 2. Map questions to IDs for easy access
        $questions = Question::with('options')->get()->keyBy('id');
        $sections = Section::where('is_active', true)
            ->with(['questions' => function($q) {
                $q->where('is_active', true)->with('options')->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // 3. Group responses by Taluka/Area
        // Grouping IDs based on report_engine.py: 93 (Village), 94 (City), 95 (Taluka), 96 (District)
        $groupedResponses = [
            'Mansa' => [],
            'Kalol' => [],
            'Dehgam' => [],
            'Gandhinagar (Rural)' => [],
            'Gandhinagar (City)' => [],
            'Other' => []
        ];

        foreach ($responses as $response) {
            $ansMap = $response->answers->keyBy('question_id');
            
            $taluka = trim($ansMap[95]->answer_value ?? '');
            $city = trim($ansMap[94]->answer_value ?? '');
            $district = trim($ansMap[96]->answer_value ?? '');

            $targetGroup = 'Other';

            // Fallback for Taluka
            if (empty($taluka) || $taluka == '-' || $taluka == '.') {
                if (str_contains($district, 'ગાંધીનગર')) {
                    $taluka = 'ગાંધીનગર';
                }
            }

            if (str_contains($taluka, 'ગાંધીનગર')) {
                // Split Gandhinagar
                if (!empty($city) && $city != '-' && strlen($city) > 1) {
                    $targetGroup = 'Gandhinagar (City)';
                } else {
                    $targetGroup = 'Gandhinagar (Rural)';
                }
            } elseif (str_contains($taluka, 'માણસા')) {
                $targetGroup = 'Mansa';
            } elseif (str_contains($taluka, 'કલોલ')) {
                $targetGroup = 'Kalol';
            } elseif (str_contains($taluka, 'દહેગામ') || str_contains($taluka, 'દેહગામ')) {
                $targetGroup = 'Dehgam';
            }

            $groupedResponses[$targetGroup][] = $response;
        }

        // 4. Generate stats for each group and for Final Combined
        $allStats = [];
        foreach ($groupedResponses as $groupName => $groupResponses) {
            if (empty($groupResponses)) continue;
            $allStats[$groupName] = $this->calculateStats($groupResponses, $questions);
        }
        
        $allStats['Final Combined'] = $this->calculateStats($responses, $questions);

        return view('admin.result_report', compact('allStats', 'sections', 'groupedResponses'));
    }

    private function calculateStats($responses, $questions)
    {
        $stats = [];
        $totalRespondents = count($responses);
        $fixedBase = 330; // Client requested % based on 330

        // Initialize counters
        foreach ($questions as $qId => $q) {
            $stats[$qId] = [
                'question' => $q->question_text_gu,
                'type' => $q->type,
                'total_responses' => 0,
                'options' => []
            ];

            if (in_array($q->type, ['radio', 'checkbox'])) {
                foreach ($q->options as $opt) {
                    $stats[$qId]['options'][$opt->id] = [
                        'text' => $opt->option_text_gu,
                        'count' => 0,
                        'percentage' => 0
                    ];
                }
            } else {
                $stats[$qId]['text_answers'] = [];
            }
        }

        // Count answers
        foreach ($responses as $response) {
            foreach ($response->answers as $ans) {
                $qId = $ans->question_id;
                if (!isset($stats[$qId])) continue;

                $val = $ans->answer_value;
                if (empty(trim($val)) || $val == '-' || $val == '.') continue;

                if (in_array($stats[$qId]['type'], ['radio', 'checkbox'])) {
                    $decoded = json_decode($val, true);
                    $ids = is_array($decoded) ? $decoded : [$val];

                    foreach ($ids as $id) {
                        if (isset($stats[$qId]['options'][$id])) {
                            $stats[$qId]['options'][$id]['count']++;
                            $stats[$qId]['total_responses']++;
                        }
                    }
                } else if ($stats[$qId]['type'] != 'table') {
                    $key = mb_strtolower(trim($val));
                    if (!isset($stats[$qId]['text_answers'][$key])) {
                        $stats[$qId]['text_answers'][$key] = [
                            'display' => $val,
                            'count' => 0
                        ];
                    }
                    $stats[$qId]['text_answers'][$key]['count']++;
                    $stats[$qId]['total_responses']++;
                }
            }
        }

        // Finalize percentages
        foreach ($stats as $qId => &$qStats) {
            if (isset($qStats['options'])) {
                foreach ($qStats['options'] as &$opt) {
                    $opt['percentage'] = round(($opt['count'] / $fixedBase) * 100, 2);
                }
            }
            if (isset($qStats['text_answers'])) {
                foreach ($qStats['text_answers'] as &$ans) {
                    $ans['percentage'] = round(($ans['count'] / $fixedBase) * 100, 2);
                }
                // Sort text answers by count
                uasort($qStats['text_answers'], fn($a, $b) => $b['count'] <=> $a['count']);
            }
        }

        return $stats;
    }
}
