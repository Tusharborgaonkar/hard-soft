@extends('admin.layout')

@section('title', 'Response Details')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
    <a href="{{ route('admin.responses') }}" class="btn btn-sm" style="background: #e2e8f0; color: #475569;">&larr; Back to List</a>
</div>

<div class="card">
    {{-- Header Section --}}
    <div style="margin-bottom: 2.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; color: var(--sidebar); margin-bottom: 0.25rem;">Response {{ $response->response_number ?? '#' . $response->id }}</h2>
                <div style="display: flex; gap: 1rem; color: var(--text-light); font-size: 0.85rem;">
                    <span><strong>IP Address:</strong> {{ $response->user_identifier }}</span>
                    <span><strong>Submitted:</strong> {{ $response->created_at->format('M d, Y | h:i A') }}</span>
                </div>
            </div>
            <a href="{{ route('admin.responses.edit', $response->id) }}" class="btn btn-primary">
                <svg style="width: 14px; height: 14px; margin-right: 4px; display: inline-block; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Response
            </a>
        </div>
    </div>

    {{-- Answers Section --}}
    @if($response->answers->isEmpty())
        <div style="text-align: center; padding: 3rem; color: var(--text-light);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">empty</div>
            <p>No answers recorded for this response.</p>
        </div>
    @else
        @foreach($response->answers as $ans)
        <div style="margin-bottom: 2rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1.5rem;">
            {{-- Question Header --}}
            <div style="margin-bottom: 1rem;">
                <div style="font-weight: 700; color: #1e293b; font-size: 1.05rem; line-height: 1.4; margin-bottom: 0.2rem;">
                    <span style="display: inline-block; width: 24px; height: 24px; background: #f1f5f9; border-radius: 50%; text-align: center; line-height: 24px; font-size: 0.8rem; margin-right: 0.5rem; color: var(--primary);">{{ $loop->iteration }}</span>
                    {{ $ans->question->question_text_gu }}
                </div>
                @if($ans->question->question_text_en)
                <div style="color: var(--text-light); font-size: 0.85rem; font-style: italic; padding-left: 2.2rem;">
                    {{ $ans->question->question_text_en }}
                </div>
                @endif
            </div>

            {{-- Answer Body --}}
            <div style="padding-left: 2.2rem;">
                <div style="background: #ffffff; border: 1px solid #edf2f7; border-left: 4px solid var(--primary); padding: 1rem; border-radius: 0 8px 8px 0; font-weight: 500; color: #2d3748; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                    @php
                        $rawVal = $ans->answer_value;
                        $decoded = json_decode($rawVal, true);
                        $isJson = (json_last_error() == JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded)));
                    @endphp

                    @if($isJson)
                        @if(isset($decoded[0]) && is_array($decoded[0]))
                            {{-- Tabular / Array of Objects Data --}}
                            @php 
                                $headers = array_keys($decoded[0]);
                                // Filter out technical keys like _row_idx
                                $headers = array_filter($headers, fn($h) => !str_starts_with($h, '_'));
                            @endphp
                            <div class="table-responsive" style="margin-top: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #fff;">
                                <table style="margin: 0; min-width: 100%; border-collapse: separate; border-spacing: 0;">
                                    <thead style="background: #f1f5f9;">
                                        <tr>
                                            @foreach($headers as $h)
                                            <th style="padding: 0.75rem 1rem; font-size: 0.7rem; text-transform: uppercase; color: #475569; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; border-right: 1px solid #e2e8f0;">{{ $h }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($decoded as $row)
                                        <tr style="background: {{ $loop->even ? '#f8fafc' : '#fff' }};">
                                            @foreach($headers as $h)
                                            @php $cellValue = trim($row[$h] ?? ''); @endphp
                                            <td style="padding: 0.75rem 1rem; font-size: 0.85rem; border-bottom: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; color: {{ $cellValue === '' ? '#cbd5e1' : '#1e293b' }};">
                                                {{ $cellValue ?: 'No record' }}
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Multi-Choice Option IDs --}}
                            @php
                                $ids = is_array($decoded) ? $decoded : [$decoded];
                                $labels = [];
                                foreach($ids as $id) {
                                    $opt = $ans->question->options->firstWhere('id', $id);
                                    $labels[] = $opt ? $opt->option_text_gu : $id;
                                }
                            @endphp
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @foreach($labels as $lbl)
                                    <span style="background: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.85rem;">{{ $lbl }}</span>
                                @endforeach
                            </div>
                        @endif
                    @else
                        {{-- Plain Text or Single Choice --}}
                        @php
                            $opt = $ans->question->options->firstWhere('id', $rawVal);
                            $displayVal = $opt ? $opt->option_text_gu : $rawVal;
                        @endphp
                        
                        @if($ans->question->type === 'radio' && $opt)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.85rem;">{{ $displayVal }}</span>
                        @else
                            <div style="line-height: 1.6; white-space: pre-wrap;">{{ $displayVal ?: '-' }}</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<style>
    .card { background: #fff; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; }
    .btn-primary { background: var(--primary); color: #fff; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; }
    .btn-primary:hover { background: var(--primary-dark); }
</style>
@endsection
