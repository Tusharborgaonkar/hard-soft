@extends('admin.layout')

@section('title', 'Response Details')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.responses') }}" style="color: var(--primary); text-decoration: none;">&larr; Back to List</a>
</div>

<div class="card">
    <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <h2>Response #{{ $response->id }}</h2>
            <a href="{{ route('admin.responses.edit', $response->id) }}" class="btn btn-primary btn-sm">Edit Response</a>
        </div>
        <div style="color: var(--text-light); font-size: 0.875rem;">
            IP: {{ $response->user_identifier }} | Submitted: {{ $response->created_at->format('M d, Y H:i:s') }}
        </div>
    </div>

    @foreach($response->answers as $ans)
    <div style="margin-bottom: 1.5rem; border-left: 4px solid var(--primary); padding-left: 1rem;">
        <div style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.25rem;">
            {{ $ans->question->question_text_gu }}
        </div>
        <div style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.5rem;">
            {{ $ans->question->question_text_en }}
        </div>
        <div style="background: #f8fafc; padding: 0.75rem; border-radius: 6px; font-weight: 500;">
            @php $val = $ans->answer_text; @endphp
            @if(is_array(json_decode($val, true)))
                @php $decoded = json_decode($val, true); @endphp
                @if(isset($decoded[1]) && is_array($decoded[1]))
                    {{-- Table Data --}}
                    <div class="table-responsive">
                    <table class="tabulator-auto" style="font-size: 0.8rem; margin: 0;">
                        <thead>
                            <tr><th>Name</th><th>Rel</th><th>Age</th><th>Edu</th></tr>
                        </thead>
                        <tbody>
                            @foreach($decoded as $row)
                            <tr>
                                <td>{{ $row['name'] ?? '-' }}</td>
                                <td>{{ $row['rel'] ?? '-' }}</td>
                                <td>{{ $row['age'] ?? '-' }}</td>
                                <td>{{ $row['edu'] ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                @else
                    {{-- Multi-select Option IDs or names --}}
                    {{ implode(', ', $decoded) }}
                @endif
            @else
                {{ $val }}
            @endif
        </div>
        @if($ans->reason)
            @php $reasonLbl = !empty($ans->question->meta_params['reason_label']) ? $ans->question->meta_params['reason_label'] : 'શા માટે? (Reason)'; @endphp
            <div style="background: #fdf5e6; padding: 0.75rem; border: 1px solid #fed7aa; border-radius: 6px; font-size: 0.85rem; margin-top: 0.5rem; color: #9a3412;">
                <strong>{{ $reasonLbl }}:</strong> {{ $ans->reason }}
            </div>
        @endif
    </div>
    @endforeach
</div>
@endsection
