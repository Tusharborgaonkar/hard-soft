@extends('admin.layout')

@section('title', 'Edit Section')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.sections.index') }}" style="color: var(--primary); text-decoration: none;">&larr; Back to List</a>
</div>

<div class="card">
    <h2 style="margin-bottom: 1.5rem;">Edit Section: {{ $section->title_gu }}</h2>
    <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Title (Gujarati)</label>
                <input type="text" name="title_gu" value="{{ $section->title_gu }}" required placeholder="દા.ત. સામાજિક વિગતો" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
            </div>
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Title (English)</label>
                <input type="text" name="title_en" value="{{ $section->title_en }}" placeholder="e.g. Social Details" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display:flex; align-items:flex-end;">
                <label style="display:flex; align-items:center; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }} style="margin-right:0.5rem;">
                    Active Section
                </label>
            </div>
        </div>

        <div style="text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size:1rem;">Update Section</button>
        </div>
    </form>
</div>
@endsection
