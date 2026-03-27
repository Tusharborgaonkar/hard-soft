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
                <th style="min-width: 200px;">Title (Gujarati)</th>
                <th style="min-width: 200px;">Title (English)</th>
                <th style="width: 100px; text-align: center;">Questions</th>
                <th style="width: 100px; text-align: center;">Status</th>
                <th style="text-align: left; width: 140px;">Actions</th>
            </tr>
        </thead>
        <tbody class="sortable-body">
            @foreach($sections as $s)
            <tr data-id="{{ $s->id }}">
                <td class="drag-handle" style="cursor: grab; color: #cbd5e1; font-size: 1.2rem;"><span data-id="{{ $s->id }}">≡</span></td>
                <td class="order-cell">{{ $s->order }}</td>
                <td style="font-weight: 600;">{{ $s->title_gu }}</td>
                <td>{{ $s->title_en }}</td>
                <td style="text-align: center;"><span class="badge" style="background:#e0e7ff; color:#4338ca;">{{ $s->questions_count }}</span></td>
                <td style="text-align: center;">
                    @if($s->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#64748b">Inactive</span>
                    @endif
                </td>
                <td style="text-align: left;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-start;">
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
    document.addEventListener('DOMContentLoaded', function() {
        let table = new Tabulator("#sortable-sections", {
            layout: "fitData", // Allows strict manual sizing
            movableRows: true, // Enables native Tabulator drag to reorder
            movableColumns: true, // Enables column drag-and-drop
            columnDefaults: { formatter: "html", headerSort: false },
        });

        table.on("rowMoved", function(row) {
            let ids = [];
            let rows = table.getRows();
            rows.forEach((r, index) => {
                let cellHtml = r.getCells()[0].getValue();
                let match = cellHtml.match(/data-id="(\d+)"/);
                if (match) {
                    ids.push(match[1]);
                    // Update visual order
                    r.update({ "Order": index + 1 });
                }
            });

            fetch("{{ route('admin.sections.reorder') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ids: ids })
            }).catch(err => console.error(err));
        });
    });
</script>

<style>
    .sortable-ghost { opacity: 0.4; background: #f1f5f9; }
    .drag-handle:active { cursor: grabbing; }
</style>
@endsection
