<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>સામાજિક વિજ્ઞાન પ્રશ્નાવલી | Gujarat University</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Gujarati:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/gujarati_form.css') }}">
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

        {{-- Header --}}
        <div class="header">
            <div class="header-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                <span class="t" data-en="PhD Research 2024-25">પીએચ.ડી. સંશોધન ૨૦૨૪-૨૫</span>
            </div>
            <h1 class="t" data-en="Gujarat University – School of Social Sciences">ગુજરાત યુનિવર્સિટી – સ્કૂલ ઓફ સોશિયલ સાયન્સિસ</h1>
            <h2 class="t" data-en="Department of Sociology | Navrangpura, Ahmedabad">સમાજશાસ્ત્ર વિભાગ | નવરંગપુરા, અમદાવાદ</h2>
            <div class="topic-box">
                <strong class="t" data-en="Subject">વિષય</strong>:
                <span class="t" data-en='"A Sociological Study of Female Teachers in Educational Schools (Gandhinagar District)"'>"શૈક્ષણિક શાળાઓમાં મહિલા શિક્ષિકાઓ – એક સમાજશાસ્ત્રીય અભ્યાસ (ગાંધીનગર જિલ્લો)"</span>
                <br><small style="color:var(--text-muted);margin-top:.4rem;display:block;" class="t" data-en="Guide: Dr. Hardik Thakkar | Researcher: Ramesh K. Bakar">માર્ગદર્શક: ડૉ. હાર્દિક ઠક્કર | સંશોધક: રમેશ કે. બકર</small>
            </div>
        </div>

        {{-- Stepper --}}
        <div class="stepper-wrap">
            <div class="stepper" id="stepper">
                <div class="stepper-fill" id="stepperFill"></div>
                @foreach($sections as $title => $qs)
                <div class="step-item {{ $loop->first ? 'active' : '' }}" data-step="{{ $loop->index }}">
                    <div class="step-bubble"><span>{{ $loop->iteration }}</span></div>
                    <div class="step-lbl t" data-en="{{ $qs->first()->section_title_en }}">{{ $title }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- FORM --}}
        <form id="questionnaireForm">

            {{-- ==================== STEP 1 ==================== --}}
            <div class="form-step active" id="step0">
                <div class="section-header">
                    <div class="section-icon">📋</div>
                    <div>
                        <div class="section-title t" data-en="Section 1: Social & Economic Information">વિભાગ – ૧: સામાજિક અને આર્થિક માહિતી</div>
                        <div class="section-subtitle t" data-en="Basic personal and educational background">મૂળભૂત વ્યક્તિગત અને શૈક્ષણિક માહિતી</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="1. Full Name"><span class="q-number">1</span> નામ</label>
                    <input type="text" name="q1_name" placeholder="તમારું પૂરું નામ">
                </div>

                <div class="form-group">
                    <label class="t" data-en="2. Hometown"><span class="q-number">2</span> વતન</label>
                    <div class="grid-2">
                        <input type="text" name="q2_village" placeholder="ગામ">
                        <input type="text" name="q2_city" placeholder="શહેર">
                        <input type="text" name="q2_taluka" placeholder="તાલુકો">
                        <input type="text" name="q2_district" placeholder="જિલ્લો">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="t" data-en="3. Age Group"><span class="q-number">3</span> ઉંમર</label>
                        <select name="q3_age">
                            <option value="" disabled selected>– પસંદ કરો –</option>
                            <option value="20-25" class="t" data-en="20–25 Years">૨૦–૨૫ વર્ષ</option>
                            <option value="26-30" class="t" data-en="26–30 Years">૨૬–૩૦ વર્ષ</option>
                            <option value="31-35" class="t" data-en="31–35 Years">૩૧–૩૫ વર્ષ</option>
                            <option value="35+" class="t" data-en="Above 35 Years">૩૫ ઉપર</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="t" data-en="9. Marital Status"><span class="q-number">9</span> વૈવાહિક સ્થિતિ</label>
                        <select name="q9_marital">
                            <option value="" disabled selected>– પસંદ કરો –</option>
                            <option value="Unmarried" class="t" data-en="Unmarried">અપરિણીત</option>
                            <option value="Married" class="t" data-en="Married">પરિણીત</option>
                            <option value="Divorced" class="t" data-en="Divorced">છૂટાછેડા</option>
                            <option value="Widow" class="t" data-en="Widow">વિધવા</option>
                            <option value="Separated" class="t" data-en="Separated">ત્યક્તા</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="t" data-en="4. Caste / Sub-caste"><span class="q-number">4</span> જાતિ-પેટા જાતિ</label>
                        <input type="text" name="q4_caste">
                    </div>
                    <div class="form-group">
                        <label class="t" data-en="5. Religion"><span class="q-number">5</span> ધર્મ</label>
                        <input type="text" name="q5_religion">
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="8. Languages Known"><span class="q-number">8</span> તમે કઈ ભાષા જાણો છો?</label>
                    <div class="checkbox-group">
                        <label class="check-label"><input type="checkbox" name="q8_gu"><span class="t" data-en="Gujarati">ગુજરાતી</span></label>
                        <label class="check-label"><input type="checkbox" name="q8_hi"><span class="t" data-en="Hindi">હિન્દી</span></label>
                        <label class="check-label"><input type="checkbox" name="q8_en"><span class="t" data-en="English">અંગ્રેજી</span></label>
                        <label class="check-label"><input type="checkbox" name="q8_other"><span class="t" data-en="Other">અન્ય</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="10. Educational Qualification"><span class="q-number">10</span> શૈક્ષણિક લાયકાત</label>
                    <div class="checkbox-group">
                        <label class="check-label"><input type="checkbox" name="q10_grad"><span class="t" data-en="Graduate">સ્નાતક</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_pg"><span class="t" data-en="Post Graduate">અનુસ્નાતક</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_ptc"><span>P.T.C.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_bed"><span>B.Ed.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_med"><span>M.Ed.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_cped"><span>C.P.Ed./D.P.Ed.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_mphil"><span>M.Phil.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_phd"><span>Ph.D.</span></label>
                        <label class="check-label"><input type="checkbox" name="q10_other"><span class="t" data-en="Other">અન્ય</span></label>
                    </div>
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label class="t" data-en="11. Department"><span class="q-number">11</span> શૈક્ષણિક વિભાગ</label>
                        <select name="q11_dept">
                            <option value="" disabled selected>– પસંદ –</option>
                            <option value="Sec" class="t" data-en="Secondary (Std 9-10)">માધ્યમિક (ધો.૯-૧૦)</option>
                            <option value="HighSec" class="t" data-en="Higher Sec (Std 11-12)">ઉ.માધ્ય. (ધો.૧૧-૧૨)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="t" data-en="12. Medium"><span class="q-number">12</span> શાળા માધ્યમ</label>
                        <select name="q12_medium">
                            <option value="" disabled selected>– પસંદ –</option>
                            <option value="Guj" class="t" data-en="Gujarati">ગુજરાતી</option>
                            <option value="Hin" class="t" data-en="Hindi">હિન્દી</option>
                            <option value="Eng" class="t" data-en="English">અંગ્રેજી</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="t" data-en="13. Teaching Experience"><span class="q-number">13</span> શૈક્ષણિક અનુભવ</label>
                        <select name="q13_exp">
                            <option value="" disabled selected>– પસંદ –</option>
                            <option value="<1" class="t" data-en="Less than 1 year">૧ વર્ષ કરતાં ઓછું</option>
                            <option value="1-5" class="t" data-en="1 to 5 years">૧–૫ વર્ષ</option>
                            <option value="6-10" class="t" data-en="6 to 10 years">૬–૧૦ વર્ષ</option>
                            <option value="11-20" class="t" data-en="11 to 20 years">૧૧–૨૦ વર્ષ</option>
                            <option value="21+" class="t" data-en="21+ years">૨૧+ વર્ષ</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="6. School Name"><span class="q-number">6</span> શાળાનું નામ</label>
                    <input type="text" name="q6_school_name">
                </div>
                <div class="form-group">
                    <label class="t" data-en="7. School Address"><span class="q-number">7</span> શાળાનું સરનામું</label>
                    <div class="grid-2">
                        <input type="text" name="q7_village" placeholder="ગામ">
                        <input type="text" name="q7_city" placeholder="શહેર">
                        <input type="text" name="q7_taluka" placeholder="તાલુકો">
                        <input type="text" name="q7_district" placeholder="જિલ્લો">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="t" data-en="14. Family Type"><span class="q-number">14</span> કુટુંબ પ્રકાર</label>
                        <select name="q14_family">
                            <option value="" disabled selected>– પસંદ –</option>
                            <option value="Joint" class="t" data-en="Joint Family">સંયુક્ત</option>
                            <option value="Nuclear" class="t" data-en="Nuclear Family">વિભક્ત</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="t" data-en="15. Annual Income"><span class="q-number">15</span> વાર્ષિક આવક (₹)</label>
                        <input type="text" name="q15_income">
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="16. Family Details"><span class="q-number">16</span> કૌટુંબિક માહિતી</label>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th class="t" data-en="#">ક્રમ</th>
                                    <th class="t" data-en="Name">નામ</th>
                                    <th class="t" data-en="Relation">સંબંધ</th>
                                    <th class="t" data-en="Age">ઉંમર</th>
                                    <th class="t" data-en="Education">શિક્ષણ</th>
                                    <th class="t" data-en="Status">સ્થિતિ</th>
                                    <th class="t" data-en="Occupation">વ્યવસાય</th>
                                    <th class="t" data-en="Income">આવક</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td><span class="row-num">{{ $i }}</span></td>
                                    <td><input type="text" name="fam_{{ $i }}_name"></td>
                                    <td><input type="text" name="fam_{{ $i }}_rel"></td>
                                    <td><input type="text" name="fam_{{ $i }}_age"></td>
                                    <td><input type="text" name="fam_{{ $i }}_edu"></td>
                                    <td><input type="text" name="fam_{{ $i }}_stat"></td>
                                    <td><input type="text" name="fam_{{ $i }}_job"></td>
                                    <td><input type="text" name="fam_{{ $i }}_inc"></td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="btn-row">
                    <div></div>
                    <span class="step-counter t" data-en="Step 1 of 7">સ્ટેપ ૧ / ૭</span>
                    <button type="button" class="btn btn-next">
                        <span class="t" data-en="Next">આગળ</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- ==================== STEP 2 ==================== --}}
            <div class="form-step" id="step1">
                <div class="section-header">
                    <div class="section-icon">💼</div>
                    <div>
                        <div class="section-title t" data-en="Section 2: Personality & Work Conditions">વિભાગ – ૨: વ્યક્તિત્વ અને કામની પરિસ્થિતિ</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="1. Are you satisfied with your teaching job?"><span class="q-number">1</span> તમને તમારી નોકરીથી આત્મસંતોષ છે?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q2_1" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q2_1" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                    <div class="conditional-field" data-trigger="q2_1" data-value="No">
                        <textarea name="q2_1_reason" placeholder="કારણ / Reason..." rows="2"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="2. Why do you work? (select all that apply)"><span class="q-number">2</span> નોકરી કરવા પાછળના કારણો:</label>
                    <div class="checkbox-group">
                        <label class="check-label"><input type="checkbox" name="r2"><span class="t" data-en="Financial Need">આર્થિક જરૂરિયાત</span></label>
                        <label class="check-label"><input type="checkbox" name="r3"><span class="t" data-en="Self-reliance">આત્મનિર્ભરતા</span></label>
                        <label class="check-label"><input type="checkbox" name="r4"><span class="t" data-en="Hobbies">શોખ</span></label>
                        <label class="check-label"><input type="checkbox" name="r5"><span class="t" data-en="Future Safety">ભવિષ્ય સુરક્ષા</span></label>
                        <label class="check-label"><input type="checkbox" name="r6"><span class="t" data-en="High Lifestyle">ઉચ્ચ જીવનશૈલી</span></label>
                        <label class="check-label"><input type="checkbox" name="r7"><span class="t" data-en="Education Utility">શિક્ષણ ઉપયોગ</span></label>
                    </div>
                </div>

                <hr class="field-divider">

                <div class="form-group">
                    <label class="t" data-en="4. Did your job increase your self-respect?"><span class="q-number">4</span> નોકરીથી આત્મસન્માન વધ્યું?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q2_4" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q2_4" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="7. Time spent preparing for subject (hrs/day)"><span class="q-number">7</span> વિષય તૈયારી માટે સમય:</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q2_7" value="1hr"><span class="t" data-en="1 Hour">૧ કલાક</span></label>
                        <label class="radio-label"><input type="radio" name="q2_7" value="2hr"><span class="t" data-en="2 Hours">૨ કલાક</span></label>
                        <label class="radio-label"><input type="radio" name="q2_7" value="3hr"><span class="t" data-en="3 Hours">૩ કલાક</span></label>
                        <label class="radio-label"><input type="radio" name="q2_7" value="4hr"><span class="t" data-en="4 Hours">૪ કલાક</span></label>
                        <label class="radio-label"><input type="radio" name="q2_7" value="none"><span class="t" data-en="No Preparation Needed">જરૂર નથી</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="11. Distance from residence to school"><span class="q-number">11</span> રહેઠાણથી શાળા કેટલી દૂર?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q2_11" value="2km"><span>< ૨ km</span></label>
                        <label class="radio-label"><input type="radio" name="q2_11" value="2-5km"><span>૨–૫ km</span></label>
                        <label class="radio-label"><input type="radio" name="q2_11" value="5-10km"><span>૫–૧૦ km</span></label>
                        <label class="radio-label"><input type="radio" name="q2_11" value="10+km"><span class="t" data-en="More than 10 km">૧૦+ km</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="12. Do you live in the job village or commute?"><span class="q-number">12</span> ગામમાં રહો છો કે અપ-ડાઉન?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q2_12" value="Stay"><span class="t" data-en="Live in village">ગામમાં રહું</span></label>
                        <label class="radio-label"><input type="radio" name="q2_12" value="UpDown"><span class="t" data-en="Commute daily">અપ-ડાઉન</span></label>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-prev">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        <span class="t" data-en="Back">પાછળ</span>
                    </button>
                    <span class="step-counter t" data-en="Step 2 of 7">સ્ટેપ ૨ / ૭</span>
                    <button type="button" class="btn btn-next"><span class="t" data-en="Next">આગળ</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            {{-- ==================== STEP 3 ==================== --}}
            <div class="form-step" id="step2">
                <div class="section-header">
                    <div class="section-icon">🎓</div>
                    <div><div class="section-title t" data-en="Section 3: Teacher–Student Relations">વિભાગ – ૩: શિક્ષક–વિદ્યાર્થી સંબંધ</div></div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="1. What type of relationship should teachers keep with students?"><span class="q-number">1</span> વિદ્યાર્થી સાથે કેવો સંબંધ?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q3_1" value="Intimate"><span class="t" data-en="Intimate">આત્મીય</span></label>
                        <label class="radio-label"><input type="radio" name="q3_1" value="Limited"><span class="t" data-en="Limited">મર્યાદિત</span></label>
                        <label class="radio-label"><input type="radio" name="q3_1" value="Medium"><span class="t" data-en="Medium">મધ્યમ</span></label>
                        <label class="radio-label"><input type="radio" name="q3_1" value="Formal"><span class="t" data-en="Formal">ઉપચારિક</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="5. Your opinion on students (select all that apply)"><span class="q-number">5</span> વિદ્યાર્થીઓ વિશે મત:</label>
                    <div class="checkbox-group">
                        <label class="check-label"><input type="checkbox" name="s_curious"><span class="t" data-en="Curious">જિજ્ઞાસુ</span></label>
                        <label class="check-label"><input type="checkbox" name="s_studious"><span class="t" data-en="Studious">અભ્યાસુ</span></label>
                        <label class="check-label"><input type="checkbox" name="s_playful"><span class="t" data-en="Playful">રમતીયાળ</span></label>
                        <label class="check-label"><input type="checkbox" name="s_active"><span class="t" data-en="Active">ચંચળ</span></label>
                        <label class="check-label"><input type="checkbox" name="s_cultured"><span class="t" data-en="Cultured">સંસ્કારી</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="6. Do you guide students daily?"><span class="q-number">6</span> રોજ માર્ગદર્શન?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q3_6" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q3_6" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="9. Do you help economically weaker students?"><span class="q-number">9</span> ગરીબ વિદ્યાર્થીઓને મદદ?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q3_9" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q3_9" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                    <div class="conditional-field" data-trigger="q3_9" data-value="Yes">
                        <div class="checkbox-group" style="margin-top:.5rem">
                            <label class="check-label"><input type="checkbox" name="help_stat"><span class="t" data-en="Stationery">સ્ટેશનરી</span></label>
                            <label class="check-label"><input type="checkbox" name="help_cloth"><span class="t" data-en="Clothes">કપડા</span></label>
                            <label class="check-label"><input type="checkbox" name="help_fin"><span class="t" data-en="Financial Aid">આર્થિક મદદ</span></label>
                        </div>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-prev"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span class="t" data-en="Back">પાછળ</span></button>
                    <span class="step-counter t" data-en="Step 3 of 7">સ્ટેપ ૩ / ૭</span>
                    <button type="button" class="btn btn-next"><span class="t" data-en="Next">આગળ</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            {{-- ==================== STEP 4 ==================== --}}
            <div class="form-step" id="step3">
                <div class="section-header">
                    <div class="section-icon">🤝</div>
                    <div><div class="section-title t" data-en="Section 4: Teacher–Co-worker Relations">વિભાગ – ૪: સહકર્મચારી સંબંધ</div></div>
                </div>

                @php
                $coworker_qs = [
                    ['name'=>'q4_1','q'=>'1','gu'=>'સહકર્મચારી સંબંધ:', 'en'=>'1. Co-worker relationship type?', 'opts'=>[['gu'=>'હકારાત્મક','en'=>'Positive'],['gu'=>'નકારાત્મક','en'=>'Negative']]],
                    ['name'=>'q4_4','q'=>'4','gu'=>'સહકારી વ્યવહાર?', 'en'=>'4. Do they behave cooperatively?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q4_7','q'=>'7','gu'=>'માન-મર્યાદા રાખે?', 'en'=>'7. Do they maintain respect?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q4_8','q'=>'8','gu'=>'વાદ-વિવાદ થાય?', 'en'=>'8. Do arguments occur?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q4_10','q'=>'10','gu'=>'મૈત્રીપૂર્ણ વ્યવહાર?', 'en'=>'10. Friendly behavior?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                ];
                @endphp

                @foreach($coworker_qs as $cq)
                <div class="form-group">
                    <label class="t" data-en="{{ $cq['en'] }}"><span class="q-number">{{ $cq['q'] }}</span> {{ $cq['gu'] }}</label>
                    <div class="radio-group">
                        @foreach($cq['opts'] as $opt)
                        <label class="radio-label"><input type="radio" name="{{ $cq['name'] }}" value="{{ $opt['en'] }}"><span class="t" data-en="{{ $opt['en'] }}">{{ $opt['gu'] }}</span></label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="btn-row">
                    <button type="button" class="btn btn-prev"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span class="t" data-en="Back">પાછળ</span></button>
                    <span class="step-counter t" data-en="Step 4 of 7">સ્ટેપ ૪ / ૭</span>
                    <button type="button" class="btn btn-next"><span class="t" data-en="Next">આગળ</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            {{-- ==================== STEP 5 ==================== --}}
            <div class="form-step" id="step4">
                <div class="section-header">
                    <div class="section-icon">🏫</div>
                    <div><div class="section-title t" data-en="Section 5: Teacher–Principal Relations">વિભાગ – ૫: આચાર્ય સંબંધ</div></div>
                </div>

                @php
                $principal_qs = [
                    ['name'=>'q5_1','q'=>'1','gu'=>'આચાર્ય સાથે સંબંધ:', 'en'=>'1. Relation with principal?', 'opts'=>[['gu'=>'હકારાત્મક','en'=>'Positive'],['gu'=>'નકારાત્મક','en'=>'Negative']]],
                    ['name'=>'q5_2','q'=>'2','gu'=>'સહકારપૂર્ણ વ્યવહાર?', 'en'=>'2. Cooperative behavior?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q5_3','q'=>'3','gu'=>'નિર્ણયમાં અભિપ્રાય?', 'en'=>'3. Opinion taken in decisions?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q5_disc','q'=>'5','gu'=>'ભેદભાવ?', 'en'=>'5. Discrimination by principal?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q5_guide','q'=>'6','gu'=>'શૈક્ષણિક માર્ગદર્શન?', 'en'=>'6. Teaching guidance received?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                    ['name'=>'q5_resp','q'=>'9','gu'=>'આચાર્ય પ્રત્યે આદર?', 'en'=>'9. Do you respect the principal?', 'opts'=>[['gu'=>'હા','en'=>'Yes'],['gu'=>'ના','en'=>'No']]],
                ];
                @endphp

                @foreach($principal_qs as $pq)
                <div class="form-group">
                    <label class="t" data-en="{{ $pq['en'] }}"><span class="q-number">{{ $pq['q'] }}</span> {{ $pq['gu'] }}</label>
                    <div class="radio-group">
                        @foreach($pq['opts'] as $opt)
                        <label class="radio-label"><input type="radio" name="{{ $pq['name'] }}" value="{{ $opt['en'] }}"><span class="t" data-en="{{ $opt['en'] }}">{{ $opt['gu'] }}</span></label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="form-group">
                    <label class="t" data-en="10. Ideal principal qualities (select all)"><span class="q-number">10</span> આદર્શ આચાર્ય:</label>
                    <div class="checkbox-group">
                        <label class="check-label"><input type="checkbox" name="ip1"><span class="t" data-en="Strong personality">પ્રભાવશાળી</span></label>
                        <label class="check-label"><input type="checkbox" name="ip2"><span class="t" data-en="Self-disciplined">શિસ્તબદ્ધ</span></label>
                        <label class="check-label"><input type="checkbox" name="ip3"><span class="t" data-en="Cooperative">સહકારી</span></label>
                        <label class="check-label"><input type="checkbox" name="ip4"><span class="t" data-en="Self-confident">આત્મવિશ્વાસી</span></label>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-prev"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span class="t" data-en="Back">પાછળ</span></button>
                    <span class="step-counter t" data-en="Step 5 of 7">સ્ટેપ ૫ / ૭</span>
                    <button type="button" class="btn btn-next"><span class="t" data-en="Next">આગળ</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            {{-- ==================== STEP 6 ==================== --}}
            <div class="form-step" id="step5">
                <div class="section-header">
                    <div class="section-icon">⚖️</div>
                    <div><div class="section-title t" data-en="Section 6: Role Conflict">વિભાગ – ૬: ભૂમિક સંઘર્ષ</div></div>
                </div>

                @php
                $conflict_qs = [
                    ['name'=>'q6_1','q'=>'1','gu'=>'બેવડી ભૂમિકા?','en'=>'1. Do you play dual role (teacher + homemaker)?'],
                    ['name'=>'q6_2','q'=>'2','gu'=>'ભૂમિક સંઘર્ષ?','en'=>'2. Do you experience role conflict?'],
                    ['name'=>'q6_3','q'=>'3','gu'=>'ઘર સંભાળ બાધક?','en'=>'3. Does job obstruct home care?'],
                    ['name'=>'q6_6','q'=>'6','gu'=>'નોકરી+ઘર – મુશ્કેલ?','en'=>'6. Is managing job+home difficult?'],
                    ['name'=>'q6_8','q'=>'8','gu'=>'શારીરિક-માનસિક થાક?','en'=>'8. Physical/mental fatigue from dual role?'],
                    ['name'=>'q6_11','q'=>'11','gu'=>'ભૂમિક સ. આરોગ્ય અસર?','en'=>'11. Does role conflict affect your health?'],
                ];
                @endphp

                @foreach($conflict_qs as $cq)
                <div class="form-group">
                    <label class="t" data-en="{{ $cq['en'] }}"><span class="q-number">{{ $cq['q'] }}</span> {{ $cq['gu'] }}</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="{{ $cq['name'] }}" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="{{ $cq['name'] }}" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>
                @endforeach

                <div class="form-group">
                    <label class="t" data-en="4. Do you fight with husband due to job?"><span class="q-number">4</span> નોકરીથી પતિ સાથે ઝઘડો?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q6_4" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q6_4" value="No"><span class="t" data-en="No">ના</span></label>
                        <label class="radio-label"><input type="radio" name="q6_4" value="Unmarried"><span class="t" data-en="Unmarried">અપરિણીત</span></label>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-prev"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span class="t" data-en="Back">પાછળ</span></button>
                    <span class="step-counter t" data-en="Step 6 of 7">સ્ટેપ ૬ / ૭</span>
                    <button type="button" class="btn btn-next"><span class="t" data-en="Next">આગળ</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></button>
                </div>
            </div>

            {{-- ==================== STEP 7 ==================== --}}
            <div class="form-step" id="step6">
                <div class="section-header">
                    <div class="section-icon">💰</div>
                    <div><div class="section-title t" data-en="Section 7: Social & Economic Status">વિભાગ – ૭: સામાજિક અને આર્થિક દરજ્જો</div></div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="1. Has your status changed due to this profession?"><span class="q-number">1</span> વ્યવસાયથી દરજ્જો બદલ્યો?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q7_1" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q7_1" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="2. How much family participation in decisions?"><span class="q-number">2</span> નિર્ણયોમાં ભાગીદારી:</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q7_2" value="Low"><span class="t" data-en="Low">ઓછી</span></label>
                        <label class="radio-label"><input type="radio" name="q7_2" value="High"><span class="t" data-en="High">વધારે</span></label>
                        <label class="radio-label"><input type="radio" name="q7_2" value="Average"><span class="t" data-en="Average">સામાન્ય</span></label>
                        <label class="radio-label"><input type="radio" name="q7_2" value="Negligible"><span class="t" data-en="Negligible">નહિવત</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="3. Has social standing risen?"><span class="q-number">3</span> સમાજમાં સ્થાન ઊંચું ગયું?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q7_3" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q7_3" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="5. Do you invest your income? If yes, where?"><span class="q-number">5</span> આવકનું રોકાણ?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q7_inv" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q7_inv" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                    <div class="conditional-field" data-trigger="q7_inv" data-value="Yes">
                        <div class="checkbox-group" style="margin-top:.5rem">
                            <label class="check-label"><input type="checkbox" name="inv_land"><span class="t" data-en="Land">જમીન</span></label>
                            <label class="check-label"><input type="checkbox" name="inv_ins"><span class="t" data-en="Insurance">વીમા</span></label>
                            <label class="check-label"><input type="checkbox" name="inv_share"><span class="t" data-en="Shares">શેર</span></label>
                            <label class="check-label"><input type="checkbox" name="inv_gold"><span class="t" data-en="Gold">સોનું</span></label>
                            <label class="check-label"><input type="checkbox" name="inv_farm"><span class="t" data-en="Farming">ખેતી</span></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="7. Can you use income independently?"><span class="q-number">7</span> આવક સ્વતંત્ર વાપરી શકો?</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="q7_7" value="Yes"><span class="t" data-en="Yes">હા</span></label>
                        <label class="radio-label"><input type="radio" name="q7_7" value="No"><span class="t" data-en="No">ના</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="t" data-en="Final thoughts (optional)"><span class="q-number">✦</span> અંતિમ વિચારો (વૈકલ્પિક)</label>
                    <textarea name="final_thoughts" rows="3" placeholder="અહીં લખો..."></textarea>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-prev"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span class="t" data-en="Back">પાછળ</span></button>
                    <span class="step-counter t" data-en="Step 7 of 7">સ્ટેપ ૭ / ૭</span>
                    <button type="submit" class="btn btn-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="t" data-en="Submit Form">ફોર્મ સબમિટ</span>
                    </button>
                </div>
            </div>

        </form>

        {{-- Success State --}}
        <div class="success-screen" id="successScreen">
            <div class="success-icon">✓</div>
            <h2 class="t" data-en="Submitted Successfully!" style="color:var(--success);font-size:1.6rem;margin-bottom:.5rem">સફળતાપૂર્વક સબમિટ!</h2>
            <p class="t" data-en="Thank you for completing the questionnaire." style="color:var(--text-muted);margin-bottom:2rem">પ્રશ્નાવલી ભરવા બદલ ધન્યવાદ.</p>
            <a href="{{ url('/') }}" class="btn btn-prev" style="text-decoration:none;display:inline-flex;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span class="t" data-en="Back to Home">હોમ પેજ પર પાછા જાઓ</span>
            </a>
        </div>

    </div>{{-- /form-inner --}}
</div>{{-- /form-container --}}

{{-- Toast --}}
<div class="toast" id="toastMsg"></div>

<script src="{{ asset('js/gujarati_form.js') }}"></script>
</body>
</html>
