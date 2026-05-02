@extends('admin.layout')

@section('title', 'Report Overview & Forms')

@section('content')
<style>
    /* Screen Styles */
    .report-container {
        background: #fff;
        padding: 3rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .report-header {
        text-align: center;
        margin-bottom: 3rem;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 1.5rem;
    }
    
    .report-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .report-subtitle {
        font-size: 1.1rem;
        color: #475569;
        margin-bottom: 1rem;
    }
    
    .report-stats {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
    }

    .section-title {
        background: #f1f5f9;
        padding: 1rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary);
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }
    
    .report-table th, .report-table td {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        text-align: left;
    }
    
    .report-table th {
        background: #f8fafc;
        font-weight: 600;
    }

    .bar-chart-container {
        width: 100%;
        background: #e2e8f0;
        border-radius: 4px;
        height: 12px;
        overflow: hidden;
        margin-top: 0.25rem;
    }

    .bar-chart-fill {
        height: 100%;
        background: var(--primary);
    }
    
    .page-break {
        page-break-before: always;
        break-before: page;
        margin-top: 4rem;
    }

    .response-header {
        background: #1e293b;
        color: #fff;
        padding: 1rem;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .answer-block {
        margin-bottom: 1.5rem;
        border-bottom: 1px dotted #cbd5e1;
        padding-bottom: 1rem;
    }

    .q-text {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .a-text {
        color: #334155;
        padding-left: 1.5rem;
        border-left: 3px solid var(--primary);
    }

    /* Print Styles */
    @media print {
        @page {
            margin: 1cm;
        }
        body {
            background: #fff;
            color: #000;
        }
        .sidebar, .top-bar, .user-menu, .menu-toggle, .btn-print {
            display: none !important;
        }
        .main {
            margin: 0 !important;
            padding: 0 !important;
        }
        .report-container {
            box-shadow: none;
            padding: 0;
            max-width: 100%;
        }
        .bar-chart-container {
            border: 1px solid #ccc;
        }
        .bar-chart-fill {
            background-color: #6366f1 !important; /* Force color in some browsers */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .section-title {
            background: transparent !important;
            border-bottom: 2px solid #000;
            border-left: none;
            padding-left: 0;
        }
        .report-table th {
            background-color: #f1f5f9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .response-header {
            background-color: #e2e8f0 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div style="text-align: right; margin-bottom: 1rem;">
    <button onclick="window.print()" class="btn btn-primary btn-print" style="padding: 0.75rem 1.5rem; font-size: 1rem; border-radius: 8px;">
        <svg style="width:16px; height:16px; display:inline-block; vertical-align:middle; margin-right:6px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Print / Download PDF
    </button>
</div>

<div class="report-container" id="print-area">
    
    {{-- OVERVIEW SECTION --}}
    <div class="report-header">
        <div class="report-title">રિપોર્ટ: શૈક્ષણિક શાળાઓમાં શિક્ષક તરીકે નોકરી કરતી મહિલા શિક્ષિકાઓનો – એક સમાજશાસ્ત્રીય અભ્યાસ</div>
        <div class="report-subtitle">(ગાંધીનગર જિલ્લાના સંદર્ભમાં) | વર્ષ: ૨૦૨૪-૨૫</div>
        <div class="report-stats">કુલ પ્રતિસાદ (Total Responses Analyzed): {{ $totalResponses }}</div>
    </div>

    @foreach($sections as $sec)
        <div class="section-title">વિભાગ-{{ $loop->iteration }}: {{ $sec->title_gu }}</div>
        
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 50px;">ક્રમ</th>
                    <th style="width: 40%;">પ્રશ્ન (Question)</th>
                    <th style="width: 30%;">વિકલ્પો (Options)</th>
                    <th>કુલ સંખ્યા (Total)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sec->questions as $q)
                    @if(in_array($q->type, ['radio', 'checkbox']))
                        @foreach($q->options as $optIdx => $opt)
                            @php
                                $count = $optionCounts[$opt->id] ?? 0;
                                $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;
                            @endphp
                            <tr>
                                @if($optIdx === 0)
                                    <td rowspan="{{ $q->options->count() }}">{{ $loop->parent->iteration }}</td>
                                    <td rowspan="{{ $q->options->count() }}">
                                        {{ $q->question_text_gu }}
                                        @if($q->question_text_en) <br><small style="color:#64748b;">{{ $q->question_text_en }}</small> @endif
                                    </td>
                                @endif
                                <td>{{ $opt->option_text_gu }}</td>
                                <td>
                                    <strong>{{ $count }}</strong> <span style="font-size:0.8rem; color:#64748b;">({{ $percentage }}%)</span>
                                    <div class="bar-chart-container">
                                        <div class="bar-chart-fill" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(in_array($q->type, ['text', 'number', 'textarea']))
                        @php
                            $answers = $textCounts[$q->id] ?? [];
                            // Sort answers by count descending
                            uasort($answers, function($a, $b) {
                                return $b['count'] <=> $a['count'];
                            });
                        @endphp
                        
                        @if(empty($answers))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $q->question_text_gu }}</td>
                                <td colspan="2" style="color: #64748b; font-style: italic;">No responses yet</td>
                            </tr>
                        @else
                            @foreach($answers as $key => $data)
                                @php
                                    $count = $data['count'];
                                    $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100) : 0;
                                @endphp
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ count($answers) }}">{{ $loop->parent->iteration }}</td>
                                        <td rowspan="{{ count($answers) }}">
                                            {{ $q->question_text_gu }}
                                            @if($q->question_text_en) <br><small style="color:#64748b;">{{ $q->question_text_en }}</small> @endif
                                        </td>
                                    @endif
                                    <td>{{ $data['display'] }}</td>
                                    <td>
                                        <strong>{{ $count }}</strong> <span style="font-size:0.8rem; color:#64748b;">({{ $percentage }}%)</span>
                                        <div class="bar-chart-container">
                                            <div class="bar-chart-fill" style="width: {{ $percentage }}%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        {{-- Table questions or others --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $q->question_text_gu }}
                            </td>
                            <td colspan="2" style="color: #64748b; font-style: italic;">
                                Tabular Data (See detailed individual responses below)
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach


    {{-- INDIVIDUAL FORM DATA (PAGE BREAK) --}}
    <div class="page-break"></div>
    <div class="report-header">
        <div class="report-title">Individual Form Data</div>
        <div class="report-subtitle">Detailed Responses</div>
    </div>

    @foreach($responses as $response)
        <div class="page-break" style="margin-top: 2rem;"></div>
        <div class="response-header">
            Response #{{ $response->response_number }}
        </div>
        
        <div style="margin-bottom: 2rem;">
            <div style="margin-bottom: 1rem; color: #475569; font-size: 0.9rem;">
                <strong>Date Submitted:</strong> {{ $response->created_at->format('d M Y, h:i A') }}
            </div>

            @foreach($sections as $sec)
                <div style="font-weight: 700; color: var(--primary); margin-top: 1.5rem; margin-bottom: 0.5rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.25rem;">
                    {{ $sec->title_gu }}
                </div>

                @foreach($sec->questions as $q)
                    @php
                        // Find the answer for this question in this response
                        $ans = $response->answers->firstWhere('question_id', $q->id);
                    @endphp

                    <div class="answer-block">
                        <div class="q-text">{{ $loop->iteration }}. {{ $q->question_text_gu }}</div>
                        <div class="a-text">
                            @if(!$ans)
                                <span style="color:#94a3b8; font-style:italic;">No Answer</span>
                            @else
                                @php
                                    $rawVal = $ans->answer_value;
                                    $decoded = json_decode($rawVal, true);
                                    $isJson = (json_last_error() == JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded)));
                                @endphp

                                @if($isJson)
                                    @if(isset($decoded[0]) && is_array($decoded[0]))
                                        {{-- Tabular data print format --}}
                                        <table style="width:100%; border-collapse:collapse; margin-top:0.5rem;">
                                            @php 
                                                $headers = array_filter(array_keys($decoded[0]), fn($h) => !str_starts_with($h, '_'));
                                            @endphp
                                            <tr>
                                                @foreach($headers as $h)
                                                    <th style="border: 1px solid #e2e8f0; padding:4px; font-size:0.8rem; background:#f8fafc;">{{ $h }}</th>
                                                @endforeach
                                            </tr>
                                            @foreach($decoded as $row)
                                            <tr>
                                                @foreach($headers as $h)
                                                    <td style="border: 1px solid #e2e8f0; padding:4px; font-size:0.8rem;">{{ trim($row[$h] ?? '') ?: '-' }}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        {{-- Checkbox --}}
                                        @php
                                            $ids = is_array($decoded) ? $decoded : [$decoded];
                                            $labels = [];
                                            foreach($ids as $id) {
                                                $opt = $q->options->firstWhere('id', $id);
                                                $labels[] = $opt ? $opt->option_text_gu : $id;
                                            }
                                        @endphp
                                        {{ implode(', ', $labels) }}
                                    @endif
                                @else
                                    {{-- Radio or Text --}}
                                    @php
                                        $opt = $q->options->firstWhere('id', $rawVal);
                                    @endphp
                                    {{ $opt ? $opt->option_text_gu : $rawVal }}
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @endforeach

</div>
@endsection
