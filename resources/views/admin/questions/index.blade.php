@extends('admin.layout')

@section('title', 'Manage Questions')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h2>All Questions</h2>
        {{-- For now no 'Add New' as we use Markdown as Source of Truth, but we can toggle activity --}}
    </div>
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Section</th>
                <th>Question (GU)</th>
                <th>Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $q)
            <tr>
                <td>{{ $q->order }}</td>
                <td>{{ $q->section_title_gu }}</td>
                <td>{{ $q->question_text_gu }}</td>
                <td><span class="badge badge-warning">{{ strtoupper($q->type) }}</span></td>
                <td>
                    @if($q->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#64748b">Inactive</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.questions.toggle', $q->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm" style="background: {{ $q->is_active ? 'var(--danger)' : 'var(--success)' }}">
                            {{ $q->is_active ? 'Disable' : 'Enable' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
