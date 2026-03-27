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
                <td>#{{ $resp->id }}</td>
                <td>{{ $resp->user_identifier }}</td>
                <td>{{ $resp->answers_count }}</td>
                <td>{{ $resp->created_at->format('M d, Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.responses.show', $resp->id) }}" class="btn btn-primary btn-sm">View Details</a>
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
