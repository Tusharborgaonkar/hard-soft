@extends('admin.layout')

@section('title', 'Manage Sections')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
        <h2>All Sections</h2>
        <a href="{{ route('admin.sections.create') }}" class="btn btn-primary">+ Add New Section</a>
    </div>

    <div class="table-responsive">
    <table id="sortable-sections">
        <thead>
            <tr>
                <th style="width: 40px;"></th>
                <th style="width: 50px;">Order</th>
                <th>Title (Gujarati)</th>
                <th>Title (English)</th>
                <th>Questions</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody class="sortable-body">
            @foreach($sections as $s)
            <tr data-id="{{ $s->id }}">
                <td class="drag-handle" style="cursor: grab; color: #cbd5e1; font-size: 1.2rem;">≡</td>
                <td class="order-cell">{{ $s->order }}</td>
                <td style="font-weight: 600;">{{ $s->title_gu }}</td>
                <td>{{ $s->title_en }}</td>
                <td><span class="badge" style="background:#e0e7ff; color:#4338ca;">{{ $s->questions_count }}</span></td>
                <td>
                    @if($s->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#64748b">Inactive</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.sections.edit', $s->id) }}" class="btn btn-sm" style="background: #e0e7ff; color: #4338ca;">Edit</a>
                        <form action="{{ route('admin.sections.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Deleting a section will delete all its questions. Are you sure?')">
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

<script>
    new Sortable(document.querySelector('.sortable-body'), {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            let ids = [];
            document.querySelectorAll('.sortable-body tr').forEach((tr, index) => {
                ids.push(tr.dataset.id);
                tr.querySelector('.order-cell').textContent = index + 1;
            });

            fetch("{{ route('admin.sections.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ids: ids })
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      // Optional: Show a subtle success toast
                  }
              });
        }
    });
</script>

<style>
    .sortable-ghost { opacity: 0.4; background: #f1f5f9; }
    .drag-handle:active { cursor: grabbing; }
</style>
@endsection
