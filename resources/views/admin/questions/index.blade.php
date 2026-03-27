@extends('admin.layout')

@section('title', 'Manage Questions')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
        <h2>Manage Questionnaire</h2>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">+ Add New Question</a>
    </div>

    {{-- Section Tabs --}}
    @php $allSections = $questions->groupBy('section.title_gu'); @endphp
    <div class="section-tabs-wrapper"
         style="
            display: flex;
            flex-wrap: nowrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.5rem;

            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;

            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
         ">
        @foreach($allSections as $section => $qs)
            <button class="section-tab {{ $loop->first ? 'active' : '' }}" 
                    onclick="showSection('section-{{ $loop->index }}', this)"
                    style="
                        flex: 0 0 auto;
                        min-width: max-content;
                        white-space: nowrap;
                        padding: 0.6rem 1.2rem;
                        border: none;
                        background: transparent;
                        cursor: pointer;
                        border-radius: 8px;
                        font-weight: 600;
                        color: #64748b;
                        transition: all 0.2s;
                    ">
                @php
                    $titleStr = $section ?: 'Uncategorized';
                    $parts = explode(':', $titleStr, 2);
                @endphp
                @if(count($parts) > 1)
                    <div style="font-size: 0.75rem; opacity: 0.8; margin-bottom: 3px;">{{ trim($parts[0]) }}:</div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        {{ trim($parts[1]) }}
                        <span style="font-size: 0.7rem; background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 99px;">{{ $qs->count() }}</span>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        {{ $titleStr }}
                        <span style="font-size: 0.7rem; background: rgba(0,0,0,0.05); padding: 2px 6px; border-radius: 99px;">{{ $qs->count() }}</span>
                    </div>
                @endif
            </button>
        @endforeach
    </div>
</div>

<div class="card" style="margin-top: 1.5rem;">
    {{-- Section Content --}}
    @foreach($allSections as $section => $sectionQuestions)
    <div id="section-{{ $loop->index }}" class="section-content" style="{{ $loop->first ? '' : 'display: none;' }}">
        <h3 style="margin-bottom: 1rem; color: var(--primary);">
            વિભાગ: {{ $section ?: 'Uncategorized' }}
        </h3>
        
        <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 250px;">Question (Gujarati)</th>
                    <th style="width: 100px; text-align: center;">Type</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="text-align: left; width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sectionQuestions as $q)
                <tr data-id="{{ $q->id }}">
                    <td class="drag-handle" style="cursor: grab; color: #cbd5e1; font-size: 1.2rem;"><span data-id="{{ $q->id }}">≡</span></td>
                    <td class="order-num">{{ $q->order }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $q->question_text_gu }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-light);">{{ $q->question_text_en }}</div>
                    </td>
                    <td style="text-align: center;"><span class="badge badge-warning">{{ strtoupper($q->type) }}</span></td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.questions.toggle', $q->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none; cursor:pointer;">
                                @if($q->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge" style="background:#f1f5f9;color:#64748b">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align: left;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-start;">
                            <a href="{{ route('admin.questions.edit', $q->id) }}" class="btn btn-sm" style="background: #e0e7ff; color: #4338ca;">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #b91c1c;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @endforeach
</div>

<style>
    .section-tab.active {
        background: var(--primary) !important;
        color: white !important;
    }
    .section-tab:hover:not(.active) {
        background: #f1f5f9;
        color: var(--primary);
    }
    .drag-handle:active { cursor: grabbing; }

    /* Custom Scrollbar */
    .section-tabs-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .section-tabs-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5f5;
        border-radius: 10px;
    }
</style>

<script>
    let tabulatorInstances = [];

    function showSection(id, btn) {
        document.querySelectorAll('.section-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.section-tab').forEach(el => el.classList.remove('active'));
        
        document.getElementById(id).style.display = 'block';
        btn.classList.add('active');
        
        // Ensure the active tabulator table correctly redraws its columns
        let target = tabulatorInstances.find(t => t.id === id);
        if (target) {
            target.instance.redraw();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Tabulator for each section table
        document.querySelectorAll('.admin-table').forEach(tableEl => {
            let sectionContentDiv = tableEl.closest('.section-content');
            let table = new Tabulator(tableEl, {
                layout: "fitData", // Allows strict manual sizing
                movableRows: true, // Enables native drag-and-drop
                movableColumns: true, // Enables column drag-and-drop
                columnDefaults: { formatter: "html", headerSort: false },
            });

            table.on("rowMoved", function(row) {
                let ids = [];
                let rows = table.getRows();
                rows.forEach((r, index) => {
                    // Extract data-id trick: grab HTML of first column (drag handle)
                    let cellHtml = r.getCells()[0].getValue();
                    let match = cellHtml.match(/data-id="(\d+)"/);
                    if (match) {
                        ids.push(match[1]);
                        // Update visual order-num
                        r.update({ "Field1": index + 1 });
                    }
                });

                fetch("{{ route('admin.questions.reorder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ ids: ids })
                }).catch(err => console.error(err));
            });

            tabulatorInstances.push({ id: sectionContentDiv.id, instance: table });
        });
    });
</script>
@endsection
