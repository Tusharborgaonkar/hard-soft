/**
 * Gujarati Questionnaire - Premium Multi-Step Form
 * Handles: step navigation, pill selection, conditional fields,
 *          bilingual toggle, validation, localStorage, toast
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- References ---- */
    const steps        = document.querySelectorAll('.form-step');
    const stepItems    = document.querySelectorAll('.step-item');
    const stepperFill  = document.getElementById('stepperFill');
    const langSwitch   = document.getElementById('langSwitch');
    const form         = document.getElementById('questionnaireForm');
    const successScreen = document.getElementById('successScreen');
    const toast        = document.getElementById('toastMsg');

    const TOTAL = steps.length;
    let current = 0;

    /* ---- Restore progress from localStorage ---- */
    const savedStep = parseInt(localStorage.getItem('guj_step') || '0', 10);
    if (savedStep > 0 && savedStep < TOTAL) {
        current = savedStep;
    }

    restoreFormData();
    updateUI();
    initPills();
    initConditionals();

    /* ==================================================
       STEPPER
    ================================================== */
    function updateUI() {
        steps.forEach((step, i) => step.classList.toggle('active', i === current));

        stepItems.forEach((item, i) => {
            item.classList.remove('active', 'completed');
            if (i < current) item.classList.add('completed');
            else if (i === current) item.classList.add('active');
        });

        /* Fill width: from first to last step */
        if (TOTAL > 1) {
            const pct = (current / (TOTAL - 1)) * 100;
            stepperFill.style.width = pct + '%';
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
        localStorage.setItem('guj_step', current);
    }

    /* ==================================================
       NAVIGATION
    ================================================== */
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', () => {
            if (validate(steps[current])) {
                if (current < TOTAL - 1) { current++; updateUI(); }
            }
        });
    });

    document.querySelectorAll('.btn-prev').forEach(btn => {
        btn.addEventListener('click', () => {
            if (current > 0) { current--; updateUI(); }
        });
    });

    /* ==================================================
       FORM SUBMIT
    ================================================== */
    form.addEventListener('submit', e => {
        e.preventDefault();
        if (validate(steps[current])) {
            form.style.display = 'none';
            document.querySelector('.stepper-wrap').style.display = 'none';
            successScreen.classList.add('active');
            localStorage.removeItem('guj_step');
            localStorage.removeItem('guj_form_data');
        }
    });

    /* ==================================================
       VALIDATION
    ================================================== */
    function validate(stepEl) {
        return true; // Temporary disable validation
        
        let valid = true;

        /* Text / select / textarea required fields */
        stepEl.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
            if (input.type === 'radio' || input.type === 'checkbox') return;
            const group = input.closest('.form-group');
            if (!group) return;

            if (!input.value.trim()) {
                markInvalid(group, langSwitch.checked ? 'This field is required.' : 'આ માહિતી ફરજિયાત છે.');
                valid = false;
            } else {
                markValid(group);
            }
        });

        /* Radio required groups */
        const radioNames = new Set();
        stepEl.querySelectorAll('input[type="radio"][required]').forEach(r => radioNames.add(r.name));
        radioNames.forEach(name => {
            const radios = stepEl.querySelectorAll(`input[name="${name}"]`);
            const group  = radios[0]?.closest('.form-group');
            if (!group) return;
            const checked = [...radios].some(r => r.checked);
            if (!checked) {
                markInvalid(group, langSwitch.checked ? 'Please select one option.' : 'એક વિકલ્પ પસંદ કરો.');
                valid = false;
            } else {
                markValid(group);
            }
        });

        if (!valid) {
            showToast(langSwitch.checked ? '⚠️ Please fill all required fields.' : '⚠️ બધી ફરજિયાત માહિતી ભરો.', 'error');
        }

        return valid;
    }

    function markInvalid(group, msg) {
        group.classList.add('invalid');
        let err = group.querySelector('.error-msg');
        if (!err) {
            err = document.createElement('div');
            err.className = 'error-msg';
            group.appendChild(err);
        }
        err.textContent = '⚠ ' + msg;
        err.style.display = 'flex';
    }

    function markValid(group) {
        group.classList.remove('invalid');
        const err = group.querySelector('.error-msg');
        if (err) err.style.display = 'none';
    }

    /* Clear validation on interaction */
    form.addEventListener('input', e => {
        const group = e.target.closest('.form-group');
        if (group) markValid(group);
        saveFormData();
    });
    form.addEventListener('change', e => {
        const group = e.target.closest('.form-group');
        if (group) markValid(group);
        saveFormData();
    });

    /* ==================================================
       PILL SELECTION (radio & checkbox)
    ================================================== */
    function initPills() {
        /* Radio pills */
        document.querySelectorAll('.radio-label').forEach(label => {
            const input = label.querySelector('input[type="radio"]');
            if (!input) return;

            input.addEventListener('change', () => {
                document.querySelectorAll(`input[name="${input.name}"]`).forEach(r => {
                    r.closest('.radio-label')?.classList.remove('selected');
                });
                if (input.checked) label.classList.add('selected');
                checkConditionals(input);
            });

            /* Restore from localStorage */
            if (input.checked) label.classList.add('selected');
        });

        /* Checkbox pills */
        document.querySelectorAll('.check-label').forEach(label => {
            const input = label.querySelector('input[type="checkbox"]');
            if (!input) return;
            input.addEventListener('change', () => {
                label.classList.toggle('selected', input.checked);
            });
            if (input.checked) label.classList.add('selected');
        });
    }

    /* ==================================================
       CONDITIONAL FIELDS
    ================================================== */
    function initConditionals() {
        document.querySelectorAll('.conditional-field').forEach(field => {
            const trigger = field.dataset.trigger;
            const value   = field.dataset.value;
            const radios  = document.querySelectorAll(`input[name="${trigger}"]`);

            radios.forEach(r => {
                r.addEventListener('change', () => checkConditionals(r));
            });
        });
    }

    function checkConditionals(radio) {
        document.querySelectorAll(`.conditional-field[data-trigger="${radio.name}"]`).forEach(field => {
            const show = radio.value === field.dataset.value && radio.checked;
            field.classList.toggle('show', show);
        });
    }

    /* ==================================================
       LANGUAGE TOGGLE
    ================================================== */
    langSwitch.addEventListener('change', () => {
        setLanguage(langSwitch.checked ? 'en' : 'gu');
    });

    function setLanguage(lang) {
        document.querySelectorAll('.t').forEach(el => {
            if (lang === 'en') {
                if (!el.dataset.gu) el.dataset.gu = el.innerHTML;
                if (el.dataset.en) el.innerHTML = el.dataset.en;
            } else {
                if (el.dataset.gu) el.innerHTML = el.dataset.gu;
            }
        });
    }

    /* ==================================================
       LOCALSTORAGE SAVE / RESTORE
    ================================================== */
    function saveFormData() {
        const data = {};
        form.querySelectorAll('input, select, textarea').forEach(el => {
            if (!el.name) return;
            if (el.type === 'radio' || el.type === 'checkbox') {
                if (el.checked) data[el.name] = el.value;
            } else {
                data[el.name] = el.value;
            }
        });
        localStorage.setItem('guj_form_data', JSON.stringify(data));
    }

    function restoreFormData() {
        const raw = localStorage.getItem('guj_form_data');
        if (!raw) return;
        const data = JSON.parse(raw);
        Object.entries(data).forEach(([name, value]) => {
            const el = form.querySelector(`[name="${name}"]`);
            if (!el) return;
            if (el.type === 'radio') {
                const r = form.querySelector(`input[name="${name}"][value="${value}"]`);
                if (r) { r.checked = true; checkConditionals(r); }
            } else if (el.type === 'checkbox') {
                el.checked = true;
            } else {
                el.value = value;
            }
        });
    }

    /* ==================================================
       TOAST
    ================================================== */
    let toastTimer;
    function showToast(msg, type = 'success') {
        toast.textContent = msg;
        toast.className = `toast toast-${type} show`;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
    }

});
