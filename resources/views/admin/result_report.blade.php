@extends('admin.layout')

@section('title', 'Final Result Report')

@section('content')
<style>
    :root {
        --premium-blue: #1e40af;
        --premium-bg: #f8fafc;
        --premium-border: #e2e8f0;
    }

    .report-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
        border: 1px solid var(--premium-border);
    }

    .report-header {
        background: linear-gradient(135deg, var(--premium-blue), #3b82f6);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .report-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .report-header p {
        opacity: 0.9;
        font-size: 1rem;
    }

    .nav-tabs-custom {
        display: flex;
        gap: 1rem;
        padding: 1rem 2rem;
        background: #fff;
        border-bottom: 1px solid var(--premium-border);
        overflow-x: auto;
    }

    .tab-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 99px;
        border: 1px solid var(--premium-border);
        background: #fff;
        color: #64748b;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .tab-btn.active {
        background: var(--premium-blue);
        color: white;
        border-color: var(--premium-blue);
    }

    .tab-content {
        display: none;
        padding: 2rem;
    }

    .tab-content.active {
        display: block;
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .stats-table th {
        background: #f1f5f9;
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        color: #1e293b;
        border: 1px solid var(--premium-border);
    }

    .stats-table td {
        padding: 0.75rem 1rem;
        border: 1px solid var(--premium-border);
        vertical-align: top;
    }

    .section-divider {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        font-weight: 800;
        color: var(--premium-blue);
        font-size: 1.1rem;
        border-left: 4px solid var(--premium-blue);
        margin: 2rem 0 1rem 0;
    }

    .percentage-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        margin-top: 4px;
        overflow: hidden;
    }

    .percentage-fill {
        height: 100%;
        background: var(--premium-blue);
        border-radius: 4px;
    }

    .print-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: #ef4444;
        color: white;
        padding: 1rem 2rem;
        border-radius: 99px;
        font-weight: 700;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        border: none;
        z-index: 100;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media print {
        .nav-tabs-custom, .sidebar, .top-bar, .print-btn {
            display: none !important;
        }
        .tab-content {
            display: block !important;
            page-break-after: always;
            padding: 0;
        }
        .report-card {
            box-shadow: none;
            border: none;
        }
    }
</style>

<div class="report-card">
    <div class="report-header">
        <h1>રિઝલ્ટ - રીપોર્ટ (Result Report)</h1>
        <p>શૈક્ષણિક શાળાઓમાં શિક્ષક તરીકે નોકરી કરતી મહિલા શિક્ષિકાઓનો – એક સમાજશાસ્ત્રીય અભ્યાસ</p>
    </div>

    <div class="nav-tabs-custom">
        @foreach($allStats as $group => $stats)
            <button class="tab-btn {{ $loop->first ? 'active' : '' }}" onclick="showTab('{{ Str::slug($group) }}', this)">
                {{ $group }}
            </button>
        @endforeach
    </div>

    @foreach($allStats as $group => $stats)
        <div id="{{ Str::slug($group) }}" class="tab-content {{ $loop->first ? 'active' : '' }}">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b;">{{ $group }} રિપોર્ટ</h2>
                <div style="background: #dcfce7; color: #166534; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                    Respondents in this group: {{ $group === 'Final Combined' ? '330 (Total)' : count($groupedResponses[$group] ?? []) }}
                </div>
            </div>

            @foreach($sections as $section)
                <div class="section-divider">વિભાગ: {{ $section->title_gu }}</div>
                
                <table class="stats-table">
                    <thead>
                        <tr>
                            <th style="width: 60%;">પ્રશ્ન (Question)</th>
                            <th style="width: 20%;">ઉતરદાતાની સંખ્યા</th>
                            <th style="width: 20%;">૩૩૦ ને આધારે ટકાવારી (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($section->questions as $q)
                            @php $qStats = $stats[$q->id] ?? null; @endphp
                            @if($qStats)
                                <tr>
                                    <td colspan="3" style="background: #f8fafc; font-weight: 700;">
                                        {{ $loop->iteration }}. {{ $q->question_text_gu }}
                                    </td>
                                </tr>
                                
                                @if(isset($qStats['options']) && !empty($qStats['options']))
                                    @foreach($qStats['options'] as $opt)
                                        <tr>
                                            <td style="padding-left: 2rem;">{{ $opt['text'] }}</td>
                                            <td style="text-align: center; font-weight: 600;">{{ $opt['count'] }}</td>
                                            <td>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <span style="font-weight: 700; color: var(--premium-blue);">{{ $opt['percentage'] }}%</span>
                                                </div>
                                                <div class="percentage-bar">
                                                    <div class="percentage-fill" style="width: {{ $opt['percentage'] }}%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif(isset($qStats['text_answers']) && !empty($qStats['text_answers']))
                                    @foreach(array_slice($qStats['text_answers'], 0, 10) as $ans)
                                        <tr>
                                            <td style="padding-left: 2rem;">{{ $ans['display'] }}</td>
                                            <td style="text-align: center; font-weight: 600;">{{ $ans['count'] }}</td>
                                            <td>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <span style="font-weight: 700; color: var(--premium-blue);">{{ $ans['percentage'] }}%</span>
                                                </div>
                                                <div class="percentage-bar">
                                                    <div class="percentage-fill" style="width: {{ $ans['percentage'] }}%;"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" style="padding-left: 2rem; color: #94a3b8; font-style: italic;">No data available for this section in this group.</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    @endforeach
</div>

<button class="print-btn" onclick="window.print()">
    <svg style="width:20px; height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
    Download Full Report (PDF)
</button>

<script>
    function showTab(tabId, btn) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        // Remove active from all buttons
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        
        // Show target
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }
</script>
@endsection
