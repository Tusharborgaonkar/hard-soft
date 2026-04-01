@extends('admin.layout')

@section('title', 'Add New Question')

@section('content')
<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.questions') }}" style="color: var(--primary); text-decoration: none;">&larr; Back to List</a>
</div>

<form action="{{ route('admin.questions.store') }}" method="POST">
    @csrf
    <div class="card" style="margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1.5rem;">Question Details</h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div style="grid-column: span 2;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Select Section (વિભાગ)</label>
                <select name="section_id" required style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
                    <option value="">-- Select Section --</option>
                    @foreach($sections as $sec)
                        <option value="{{ $sec->id }}">{{ $sec->title_gu }} ({{ $sec->title_en }})</option>
                    @endforeach
                </select>
                <div style="margin-top: 0.5rem; font-size: 0.85rem;">
                    <a href="{{ route('admin.sections.create') }}" style="color: var(--primary);">+ Create New Section</a>
                </div>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Question Text (Gujarati)</label>
            <textarea name="question_text_gu" required rows="3" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;"></textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Question Text (English)</label>
            <textarea name="question_text_en" rows="3" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Input Type</label>
                <select name="type" id="type-select" required style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
                    <option value="text">Text</option>
                    <option value="textarea">Textarea</option>
                    <option value="radio">Radio (Single Choice)</option>
                    <option value="checkbox">Checkbox (Multi Choice)</option>
                    <option value="table">Table (Special)</option>
                </select>
            </div>
            <div style="display:flex; align-items:flex-end;">
                <label style="display:flex; align-items:center; cursor:pointer;">
                    <input type="checkbox" name="is_required" value="1" style="margin-right:0.5rem;">
                    Required Field
                </label>
            </div>
            <div style="display:flex; align-items:flex-end;">
                <label style="display:flex; align-items:center; cursor:pointer;">
                    <input type="checkbox" name="meta_params[has_reason]" value="1" style="margin-right:0.5rem;" onchange="document.getElementById('reason-label-container').style.display = this.checked ? 'block' : 'none'">
                    Enable 'શા માટે?' (Why?)
                </label>
            </div>
        </div>
        <div id="reason-label-container" style="margin-top: 1.5rem; display: none;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Custom Text Field Label</label>
            <input type="text" name="meta_params[reason_label]" placeholder="If blank, defaults to: શા માટે ? (Why?)" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
        </div>
    </div>

    <div id="options-container" class="card" style="display: none; margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Options</h2>
        <div id="options-list">
            <!-- Dynamic Options -->
        </div>
        <button type="button" id="add-option" class="btn" style="background: #e0e7ff; color: #4338ca; margin-top: 1rem;">+ Add Option</button>
    </div>

    {{-- Table Builder --}}
    <div id="table-config-container" class="card" style="display: none; margin-bottom: 2rem;">
        <h2 style="margin-bottom: 1rem;">Table Configuration</h2>
        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Columns (Comma separated)</label>
            <input type="text" name="meta_params[columns]" placeholder="e.g. Name, Relation, Age, Education" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Rows (Comma separated or number)</label>
            <input type="text" name="meta_params[rows]" placeholder="e.g. 1, 2, 3, 4, 5" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:8px;">
        </div>
    </div>

    <div style="text-align: right;">
        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size:1rem;">Save Question</button>
    </div>
</form>

<script>
    const typeSelect = document.getElementById('type-select');
    const optionsContainer = document.getElementById('options-container');
    const tableConfigContainer = document.getElementById('table-config-container');
    const optionsList = document.getElementById('options-list');
    const addOptionBtn = document.getElementById('add-option');
    let optionCount = 0;

    typeSelect.addEventListener('change', () => {
        const val = typeSelect.value;
        optionsContainer.style.display = (val === 'radio' || val === 'checkbox') ? 'block' : 'none';
        tableConfigContainer.style.display = (val === 'table') ? 'block' : 'none';
        
        if (optionsContainer.style.display === 'block' && optionCount === 0) {
            addOption();
        }
    });

    function addOption(gu = '', en = '') {
        const idx = optionCount++;
        const div = document.createElement('div');
        div.style.display = 'grid';
        div.style.gridTemplateColumns = '1fr 1fr 50px';
        div.style.gap = '1rem';
        div.style.marginBottom = '1rem';
        div.innerHTML = `
            <input type="text" name="options[${idx}][gu]" value="${gu}" placeholder="Option (Gujarati)" style="padding:0.5rem; border:1px solid #e2e8f0; border-radius:6px;">
            <input type="text" name="options[${idx}][en]" value="${en}" placeholder="Option (English)" style="padding:0.5rem; border:1px solid #e2e8f0; border-radius:6px;">
            <button type="button" class="remove-option" style="background:#fee2e2; color:#b91c1c; border:none; border-radius:6px; cursor:pointer;">&times;</button>
        `;
        div.querySelector('.remove-option').onclick = () => div.remove();
        optionsList.appendChild(div);
    }

    addOptionBtn.onclick = () => addOption();
</script>
@endsection
