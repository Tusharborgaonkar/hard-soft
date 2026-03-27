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
    <div style="display: flex; gap: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch;">
        @foreach($allSections as $section => $qs)
            <button class="section-tab {{ $loop->first ? 'active' : '' }}" 
                    onclick="showSection('section-{{ $loop->index }}', this)"
                    style="padding: 0.6rem 1.2rem; border: none; background: transparent; cursor: pointer; border-radius: 8px; font-weight: 600; color: #64748b; transition: all 0.2s;">
                {{ $section ?: 'Uncategorized' }}
                <span style="font-size: 0.75rem; background: #f1f5f9; padding: 2px 6px; border-radius: 99px; margin-left: 4px;">{{ $qs->count() }}</span>
            </button>
        @endforeach
    </div>

    {{-- Section Content --}}
    @foreach($allSections as $section => $sectionQuestions)
    <div id="section-{{ $loop->index }}" class="section-content" style="{{ $loop->first ? '' : 'display: none;' }}">
        <h3 style="margin-bottom: 1rem; color: var(--primary);">
            વિભાગ: {{ $section ?: 'Uncategorized' }}
        </h3>
        
        <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;"></th>
                    <th style="width: 50px;">#</th>
                    <th>Question (Gujarati)</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody class="sortable-questions" data-section="{{ $loop->index }}">
                @foreach($sectionQuestions as $q)
                <tr data-id="{{ $q->id }}">
                    <td class="drag-handle" style="cursor: grab; color: #cbd5e1; font-size: 1.2rem;">≡</td>
                    <td class="order-num">{{ $q->order }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $q->question_text_gu }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-light);">{{ $q->question_text_en }}</div>
                    </td>
                    <td><span class="badge badge-warning">{{ strtoupper($q->type) }}</span></td>
                    <td>
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
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
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
    .sortable-ghost { opacity: 0.4; background: #f1f5f9; }
    .drag-handle:active { cursor: grabbing; }
    /* Hide scrollbar but keep functionality */
    div::-webkit-scrollbar { display: none; }
    div { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function showSection(id, btn) {
        document.querySelectorAll('.section-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.section-tab').forEach(el => el.classList.remove('active'));
        
        document.getElementById(id).style.display = 'block';
        btn.classList.add('active');
    }

    // Initialize sorting for each section table
    document.querySelectorAll('.sortable-questions').forEach(tbody => {
        new Sortable(tbody, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                let ids = [];
                tbody.querySelectorAll('tr').forEach((tr, index) => {
                    ids.push(tr.dataset.id);
                    tr.querySelector('.order-num').textContent = index + 1;
                });

                fetch("{{ route('admin.questions.reorder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ ids: ids })
                });
            }
        });
    });
</script>
@endsection
