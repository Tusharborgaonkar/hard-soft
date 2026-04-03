<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>સામાજિક વિજ્ઞાન પ્રશ્નાવલી | Gujarat University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Gujarati:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tabulator-tables@6.2.1/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@6.2.1/dist/js/tabulator.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/gujarati_form.css') }}?v={{ filemtime(public_path('css/gujarati_form.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="form-container">
    <div class="form-inner">

        {{-- Language Toggle --}}
        <div class="lang-row">
            <span class="lang-label t" data-en="GU">ગુ</span>
            <label class="switch">
                <input type="checkbox" id="langSwitch">
                <span class="slider"></span>
            </label>
            <span class="lang-label">EN</span>
        </div>

        {{-- Edit Banner --}}
        @if(isset($editMode) && $editMode)
        <div style="background: var(--warning); color: #fff; padding: 0.5rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 600; display: flex; justify-content: space-between;">
            <span>Editing Response #{{ $response->response_number }}</span>
            <a href="{{ route('admin.responses.show', $response->id) }}" style="color: #fff; text-decoration: underline;">Cancel Edit</a>
        </div>
        @endif

        {{-- Header --}}
        <div class="header">
            <div class="header-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                <span class="t" data-en="PhD Research 2024-25">પીએચ.ડી. સંશોધન ૨૦૨૪-૨૫</span>
            </div>
            <h1 class="t" data-en="Gujarat University – School of Social Sciences">ગુજરાત યુનિવર્સિટી સ્કૂલ ઓફ સોશિયલ સાયન્સિસ</h1>
            <h2 class="t" data-en="Department of Sociology | Navrangpura, Ahmedabad - 380009">સમાજશાસ્ત્ર વિભાગ, સમાજ વિજ્ઞાન ભવન, ગુજરાત યુનિવર્સિટી<br>નવરંગપુરા, અમદાવાદ – 380009</h2>
            <div class="topic-box">
                <strong class="t" data-en="Subject">વિષય</strong>:
                <span class="t" data-en='"A Sociological Study of Female Teachers Employed in Educational Schools"'>"શૈક્ષણિક શાળાઓમાં શિક્ષક તરીકે નોકરી કરતી મહિલા શિક્ષિકાઓનો – એક સમાજશાસ્ત્રીય અભ્યાસ" (ગાંધીનગર જિલ્લાના સંદર્ભમાં)</span>
                <br><small style="color:var(--text-muted);margin-top:.4rem;display:block;" class="t" data-en="Guide: Dr. Hardik Thakkar (C.U. Shah Arts College) | Researcher: Ramesh K. Bakar">માર્ગદર્શક: ડૉ. હાર્દિક ઠક્કર (સી. યુ. શાહ આર્ટ્સ કોલેજ) | સંશોધક: રમેશ કે. બકર</small>
            </div>
        </div>

        {{-- Stepper --}}
        <div class="stepper-wrap">
            <div class="stepper" id="stepper">
                <div class="stepper-fill" id="stepperFill"></div>
                @foreach($sections as $index => $section)
                <div class="step-item {{ $index === 0 ? 'active' : '' }}" data-step="{{ $index }}">
                    <div class="step-bubble"><span>{{ $loop->iteration }}</span></div>
                    <div class="step-lbl t" data-en="{{ $section->title_en }}">{{ $section->title_gu }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- FORM --}}
        <form id="questionnaireForm" 
              data-edit-mode="{{ isset($editMode) ? 'true' : 'false' }}"
              data-update-url="{{ isset($response) ? route('admin.responses.update', $response->id) : '' }}"
              data-submit-url="{{ route('questionnaire.store') }}">

            {{-- Manual Response ID --}}
            <div class="response-number-box">
                <label class="t" data-en="Response No.">ક્રમ નં.</label>
                <input type="number" name="response_number" id="manual_response_number" placeholder="..." min="1" max="999" maxlength="3" oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);" value="{{ $response->response_number ?? '' }}">
            </div>
            @foreach($sections as $index => $section)
            <div class="form-step {{ $index === 0 ? 'active' : '' }}" id="step{{ $index }}">
                <div class="section-header">
                    <div class="section-icon">📋</div>
                    <div>
                        <div class="section-title t" data-en="{{ $section->title_en }}">{{ $section->title_gu }}</div>
                    </div>
                </div>

                @foreach($section->questions as $q)
                <div class="form-group">
                    <label class="t" data-en="{{ $q->question_text_en }}">
                        <span class="q-number">{{ $loop->iteration }}</span> {{ $q->question_text_gu }}
                    </label>

                    @switch($q->type)
                        @case('text')
                            <input type="text" name="q_{{ $q->id }}" placeholder="...">
                            @break

                        @case('textarea')
                            <textarea name="q_{{ $q->id }}" rows="3" placeholder="..."></textarea>
                            @break

                        @case('radio')
                            <div class="radio-group">
                                @foreach($q->options as $opt)
                                <label class="radio-label">
                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->id }}">
                                    <span class="t" data-en="{{ $opt->option_text_en }}">{{ $opt->option_text_gu }}</span>
                                </label>
                                @endforeach
                            </div>
                            @break

                        @case('checkbox')
                            <div class="checkbox-group">
                                @foreach($q->options as $opt)
                                <label class="check-label">
                                    <input type="checkbox" name="q_{{ $q->id }}[]" value="{{ $opt->id }}">
                                    <span class="t" data-en="{{ $opt->option_text_en }}">{{ $opt->option_text_gu }}</span>
                                </label>
                                @endforeach
                            </div>
                            @break

                        @case('table')
                            @php 
                                $meta = is_array($q->meta_params) ? $q->meta_params : [];
                                $colsRaw = $meta['columns'] ?? 'નામ,સંબંધ,ઉંમર,શિક્ષણ';
                                $cols = is_array($colsRaw) ? $colsRaw : array_map('trim', explode(',', $colsRaw));
                                $rowsRaw = $meta['rows'] ?? '5';
                                $rowsCount = is_numeric($rowsRaw) ? (int)$rowsRaw : (is_array($rowsRaw) ? count($rowsRaw) : count(explode(',', $rowsRaw)));
                            @endphp
                            <div class="table-wrapper">
                                <div id="tabulator-q-{{ $q->id }}" class="question-tabulator"></div>
                                <input type="hidden" name="q_{{ $q->id }}" id="hidden-q-{{ $q->id }}">
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let colNames = @json($cols);
                                    let qId = "{{ $q->id }}";
                                    let rowsCount = {{ $rowsCount }};

                                    let tabCols = [
                                        {
                                            title: "#", 
                                            field: "_row_idx", 
                                            headerSort: false, 
                                            width: 50,
                                            hozAlign: "center",
                                            formatter: function(cell) {
                                                return `<div class="row-num">${cell.getValue() || ''}</div>`;
                                            }
                                        }
                                    ];

                                    colNames.forEach(c => {
                                        tabCols.push({
                                            title: c, 
                                            field: c, 
                                            headerSort: false,
                                            minWidth: 130,
                                            editor: "input", // Switch to built-in editor for absolute reliability
                                            cellEdited: function(cell) {
                                                syncHidden();
                                            }
                                        });
                                    });

                                    let initialData = [];
                                    let isEdit = window.adminEditData && window.adminEditData['q_' + qId];
                                    
                                    if (isEdit) {
                                        initialData = window.adminEditData['q_' + qId];
                                    } else {
                                        // Generate empty rows
                                        for(let i=1; i<=rowsCount; i++) {
                                            let r = { _row_idx: i }; // ensure _row_idx is seeded
                                            colNames.forEach(c => r[c] = "");
                                            initialData.push(r);
                                        }
                                    }

                                    if (!window.formTables) window.formTables = {};
                                    window.formTables[qId] = new Tabulator("#tabulator-q-" + qId, {
                                        data: initialData,
                                        layout: "fitColumns",
                                        columns: tabCols,
                                        history: true,
                                    });

                                    function syncHidden() {
                                        let table = window.formTables[qId];
                                        if (table) {
                                            document.getElementById('hidden-q-' + qId).value = JSON.stringify(table.getData());
                                        }
                                    }

                                    // Add to global sync function
                                    if (!window.syncAllTables) {
                                        window.syncAllTables = function() {
                                            if (window.formTables) {
                                                Object.keys(window.formTables).forEach(id => {
                                                    let tbl = window.formTables[id];
                                                    document.getElementById('hidden-q-' + id).value = JSON.stringify(tbl.getData());
                                                });
                                            }
                                        };
                                    }

                                    window.formTables[qId].on("tableBuilt", syncHidden);
                                    window.formTables[qId].on("dataChanged", syncHidden);
                                    window.formTables[qId].on("cellEdited", syncHidden);
                                });
                            </script>
                            @break
                    @endswitch
                </div>

                @endforeach

                <div class="btn-row">
                    @if(!$loop->first)
                    <button type="button" class="btn btn-prev">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        <span class="t" data-en="Back">પાછળ</span>
                    </button>
                    @else
                    <div></div>
                    @endif

                    <span class="step-counter t" data-en="Step {{ $loop->iteration }} of {{ $loop->count }}">સ્ટેપ {{ $loop->iteration }} / {{ $loop->count }}</span>

                    @if(!$loop->last)
                    <button type="button" class="btn btn-next">
                        <span class="t" data-en="Next">આગળ</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                    @else
                    <button type="submit" class="btn btn-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="t" data-en="Submit Form">ફોર્મ સબમિટ</span>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </form>


        {{-- Success State --}}
        <div class="success-screen" id="successScreen">
            <div class="success-icon">✓</div>
            <h2 class="t" data-en="Submitted Successfully!" style="color:var(--success);font-size:1.6rem;margin-bottom:.5rem">સફળતાપૂર્વક સબમિટ!</h2>
            <p class="t" data-en="Thank you for completing the questionnaire." style="color:var(--text-muted);margin-bottom:2rem">પ્રશ્નાવલી ભરવા બદલ ધન્યવાદ.</p>
            <a href="{{ url('/questionnaire?reset=1') }}" class="btn btn-prev" id="fillAnotherBtn" onclick="localStorage.removeItem('guj_step'); localStorage.removeItem('guj_form_data');" style="text-decoration:none;display:inline-flex;cursor:pointer;border:1px solid #e2e8f0;background:#f8fafc;padding:0.75rem 1.5rem;border-radius:12px;color:var(--primary);font-weight:600;gap:0.5rem;align-items:center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:20px;height:20px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="t" data-en="Fill Another Form">નવું ફોર્મ ભરો</span>
            </a>
        </div>

    </div>{{-- /form-inner --}}
</div>{{-- /form-container --}}

{{-- Toast --}}
<div class="toast" id="toastMsg"></div>

<script src="{{ asset('js/gujarati_form.js') }}?v={{ time() }}"></script>
@if(isset($editMode) && $editMode)
<script>
    window.adminEditData = {!! json_encode($editData ?? null) !!};
</script>
@endif
</body>
</html>
