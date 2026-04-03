@extends('admin.layout')

@section('title', 'User Responses')

@section('content')
<div class="card">
    <h2>Submission History</h2>
    <div class="table-responsive">
    <table class="tabulator-auto">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP Address</th>
                <th>Answers</th>
                <th>Submitted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($responses as $resp)
            <tr>
                <td>{{ $resp->response_number ?? ($responses->total() - ($responses->firstItem() + $loop->index - 1)) }}</td>
                <td>{{ $resp->user_identifier }}</td>
                <td>{{ $resp->answers_count }}</td>
                <td>{{ $resp->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.responses.show', $resp->id) }}" class="btn btn-primary btn-sm">View</a>
                        <form action="{{ route('admin.responses.destroy', $resp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this response? This cannot be undone from the dashboard.');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background: var(--danger); color: #fff;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div style="margin-top: 1rem;">
        {{ $responses->links() }}
    </div>
</div>
@endsection
