
<x-app-layout title="">
{{-- ═══════════════════════════════════════════════════
     create.blade.php — New task form
     Four fields: title, description, category, status.
     On validation error: red borders + error messages under fields.
     old() keeps the user's input so they don't retype everything.
════════════════════════════════════════════════════ --}}

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&family=DM+Mono:wght@400;500&display=swap');

:root {
    --bg:        #F7F7F5;
    --surface:   #FFFFFF;
    --border:    #E8E8E4;
    --text:      #1C1C1A;
    --muted:     #888884;
    --accent:    #1C1C1A;
    --accent-fg: #FFFFFF;
    --danger:    #CC2222;
    --danger-bg: #FFF2F2;
    --danger-bd: #FFCCCC;
    --radius:    10px;
    --font:      'DM Sans', sans-serif;
    --mono:      'DM Mono', monospace;
}

*, *::before, *::after { box-sizing: border-box; }

.pg {
    background: var(--bg); min-height: 100vh;
    padding: 36px 90px; font-family: var(--font);
    display: flex; flex-direction: column;
}

/* ── Back link ── */
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--muted); text-decoration: none;
    margin-bottom: 24px; transition: color .12s;
}
.back-link:hover { color: var(--text); }

/* ── Page title ── */
.page-title {
    font-size: 27px; font-weight: 600; color: var(--text);
    letter-spacing: -0.5px; margin-bottom: 28px;
}

/* ── Form card ── */
.form-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 32px 36px;
    max-width: 640px;
    animation: slideIn .22s ease both;
}

@keyframes slideIn {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Two-column grid for category + status ── */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

/* ── Field group ── */
.field { margin-bottom: 22px; }
.field:last-of-type { margin-bottom: 0; }

/* ── Label ── */
.field-label {
    display: block;
    font-size: 13px; font-weight: 500; color: var(--text);
    margin-bottom: 7px;
}

.field-label .required { color: #CC2222; margin-left: 2px; }
.field-label .optional { color: var(--muted); font-weight: 400; font-size: 12px; margin-left: 4px; }

/* ── Input / textarea / select base ── */
.field-input,
.field-textarea,
.field-select {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    font-family: var(--font);
    color: var(--text);
    background: var(--surface);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    appearance: none;
}

.field-input:focus,
.field-textarea:focus,
.field-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(28,28,26,.07);
}

/* Error state — red border --*/
.field-input.is-error,
.field-textarea.is-error,
.field-select.is-error {
    border-color: var(--danger);
    background: var(--danger-bg);
}

.field-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }

/* Custom select arrow ── */
.select-wrap { position: relative; }
.select-wrap::after {
    content: '▾';
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    color: var(--muted); pointer-events: none; font-size: 12px;
}
.field-select { padding-right: 32px; cursor: pointer; }

/* ── Error message under a field ── */
.field-error {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: var(--danger);
    margin-top: 6px;
}

/* ── Divider before actions ── */
.form-divider {
    border: none; border-top: 1px solid var(--border);
    margin: 28px 0 24px;
}

/* ── Form action buttons ── */
.form-actions { display: flex; align-items: center; gap: 10px; }

.btn-save {
    height: 40px; padding: 0 22px;
    /* background: var(--accent); */
    color: var(--accent-fg);
    border: none; border-radius: 8px;
    font-size: 14px; font-family: var(--font); font-weight: 500;
    cursor: pointer; transition: opacity .15s;
}
.btn-save:hover { opacity: .82; }

.btn-cancel {
    height: 40px; padding: 0 16px;
    background: none; color: var(--muted);
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: 14px; font-family: var(--font); font-weight: 400;
    cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center;
    transition: all .12s;
}
.btn-cancel:hover { color: var(--text); border-color: #CCCCC8; background: #F5F5F2; }

/* ── Status option colors in the select ── */
option[value="todo"]        { color: #777772; }
option[value="in_progress"] { color: #1A5FAD; }
option[value="completed"]   { color: #1A7040; }
</style>

<div class="pg">

    {{-- Back link — goes to task list without saving --}}
    <a href="{{ route('tasks.index') }}" class="back-link">
        ← Back to tasks
    </a>

    <div class="page-title">New Task</div>

    {{--
        Form sends POST to tasks.store route.
        The store() function in the controller receives this data.
        @csrf adds a hidden security token — required on all POST forms.
    --}}
    <div class="form-card">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            {{-- ── TITLE ── --}}
            <div class="field">
                <label class="field-label" for="title">
                    Title <span class="required">*</span>
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="field-input {{ $errors->has('title') ? 'is-error' : '' }}"
                    placeholder="What needs to be done?"
                    {{--
                        old('title') — if validation failed and the user is sent back,
                        this fills the field with what they already typed.
                        Without it, the field would be blank after an error.
                    --}}
                    value="{{ old('title') }}"
                    autofocus
                >
                {{-- @error shows the error message only if this field failed validation --}}
                @error('title')
                    <div class="field-error">✕ {{ $message }}</div>
                @enderror
            </div>

            {{-- ── DESCRIPTION ── --}}
            <div class="field">
                <label class="field-label" for="description">
                    Description <span class="optional">(optional)</span>
                </label>
                {{--
                    For textarea, old() goes between the tags, not in value=""
                --}}
                <textarea
                    id="description"
                    name="description"
                    class="field-textarea {{ $errors->has('description') ? 'is-error' : '' }}"
                    placeholder="Add more details about this task..."
                    rows="4"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="field-error">✕ {{ $message }}</div>
                @enderror
            </div>

            {{-- ── CATEGORY + STATUS side by side ── --}}
            <div class="form-row">

                {{-- CATEGORY dropdown --}}
                <div class="field">
                    <label class="field-label" for="category_id">
                        Category <span class="required">*</span>
                    </label>
                    <div class="select-wrap">
                        <select
                            id="category_id"
                            name="category_id"
                            class="field-select {{ $errors->has('category_id') ? 'is-error' : '' }}"
                        >
                            <option value="">Choose a category</option>
                            {{--
                                $categories sent from controller's create() function.
                                value="{{ $category->id }}" — the ID is sent, not the name.
                                @selected re-selects the same option after a validation error.
                            --}}
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <div class="field-error">✕ {{ $message }}</div>
                    @enderror
                </div>

                {{-- STATUS dropdown --}}
                <div class="field">
                    <label class="field-label" for="status">Initial Status</label>
                    <div class="select-wrap">
                        <select id="status" name="status" class="field-select">
                            {{--
                                $statuses = Task::STATUSES sent from controller.
                                old('status','todo') — default is 'todo' on first load.
                            --}}
                            @foreach ($status as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(old('status', 'todo') === $value)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('status')
                        <div class="field-error">✕ {{ $message }}</div>
                    @enderror
                </div>

            </div>{{-- end form-row --}}

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-save bg-indigo-600">Save Task</button>
                {{-- Cancel = simple link, no form submission, goes back to task list --}}
                <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
            </div>

        </form>
    </div>

</div>
</x-app-layout>