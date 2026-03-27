@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="card stat-card">
        <h3>Total Responses</h3>
        <div class="val">{{ $stats['total_responses'] }}</div>
    </div>
    <div class="card stat-card">
        <h3>Total Questions</h3>
        <div class="val">{{ $stats['total_questions'] }}</div>
    </div>
    <div class="card stat-card">
        <h3>Active Questions</h3>
        <div class="val">{{ $stats['active_questions'] }}</div>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 1rem;">Recent Responses</h2>
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>IP Address</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['recent_responses'] as $resp)
            <tr>
                <td>#{{ $resp->id }}</td>
                <td>{{ $resp->user_identifier }}</td>
                <td>{{ $resp->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('admin.responses.show', $resp->id) }}" class="btn btn-primary btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
