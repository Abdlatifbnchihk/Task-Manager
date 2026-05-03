<x-app-layout>

{{-- ═══════════════════════════════════════════════════
     edit.blade.php — Edit task form
     Same layout as create.blade.php with two differences:
     1. Fields are pre-filled with the task's existing data using old('field', $task->field)
     2. The form uses @method('PUT') because we are updating an existing row
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
    --radius:    10px;
    --font:      'DM Sans', sans-serif;
    --mono:      'DM Mono', monospace;
}

*, *::before, *::after { box-sizing: border-box; }

.pg {
    background: var(--bg); min-height: 100vh;
    padding: 36px 90px; font-family: var(--font);
}

/* ── Back link ── */
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: var(--muted); text-decoration: none;
    margin-bottom: 24px; transition: color .12s;
}
.back-link:hover { color: var(--text); }

/* ── Title row: heading + task ID badge ── */
.title-row { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }

.page-title {
    font-size: 27px; font-weight: 600; color: var(--text);
    letter-spacing: -0.5px;
}

.task-id-badge {
    font-size: 12px; font-family: var(--mono);
    color: var(--muted); background: #EDEDEA;
    padding: 4px 9px; border-radius: 5px;
    margin-top: 4px;
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

/* ── Two-column grid ── */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }

/* ── Field group ── */
.field { margin-bottom: 22px; }

/* ── Label ── */
.field-label {
    display: block;
    font-size: 13px; font-weight: 500; color: var(--text);
    margin-bottom: 7px;
}
.field-label .required { color: #CC2222; margin-left: 2px; }
.field-label .optional  { color: var(--muted); font-weight: 400; font-size: 12px; margin-left: 4px; }

/* ── Inputs ── */
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
.field-input.is-error,
.field-textarea.is-error,
.field-select.is-error {
    border-color: var(--danger);
    background: var(--danger-bg);
}
.field-textarea { resize: vertical; min-height: 100px; line-height: 1.6; }

/* Custom select arrow */
.select-wrap { position: relative; }
.select-wrap::after {
    content: '▾';
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    color: var(--muted); pointer-events: none; font-size: 12px;
}
.field-select { padding-right: 32px; cursor: pointer; }

/* ── Error message ── */
.field-error {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: var(--danger); margin-top: 6px;
}

/* ── Current status indicator above the select ── */
.current-status {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: var(--muted); margin-bottom: 7px;
}

.status-dot {
    width: 7px; height: 7px;
    border-radius: 50%; flex-shrink: 0;
}
.dot-todo        { background: #AAAAA5; }
.dot-in_progress { background: #3B82F6; }
.dot-completed   { background: #22C55E; }

/* ── Divider ── */
.form-divider { border: none; border-top: 1px solid var(--border); margin: 28px 0 24px; }

/* ── Danger zone — delete from edit page ── */
.danger-zone {
    margin-top: 28px;
    padding: 18px 20px;
    background: #FFF8F8;
    border: 1.5px solid #FFE0E0;
    border-radius: 8px;
}
.danger-zone-title { font-size: 13px; font-weight: 500; color: #AA2222; margin-bottom: 6px; }
.danger-zone-sub   { font-size: 12px; color: var(--muted); margin-bottom: 14px; }
.btn-delete-full {
    height: 36px; padding: 0 16px;
    background: #FFF2F2; color: #BB2222;
    border: 1.5px solid #FFB8B8; border-radius: 7px;
    font-size: 13px; font-family: var(--font); font-weight: 500;
    cursor: pointer; transition: all .12s;
}
.btn-delete-full:hover { background: #FFE5E5; border-color: #FF8888; }

/* ── Action buttons ── */
.form-actions { display: flex; align-items: center; gap: 10px; }

.btn-save {
    height: 40px; padding: 0 22px;
    background: var(--accent); color: var(--accent-fg);
    border: none; border-radius: 8px;
    font-size: 14px; font-family: var(--font); font-weight: 500;
    cursor: pointer; transition: opacity .15s;
}
.btn-save:hover { opacity: .82; }

.btn-cancel {
    height: 40px; padding: 0 16px;
    background: none; color: var(--muted);
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: 14px; font-family: var(--font);
    cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center;
    transition: all .12s;
}
.btn-cancel:hover { color: var(--text); border-color: #CCCCC8; background: #F5F5F2; }
</style>

<div class="pg">

    <a href="{{ route('tasks.index') }}" class="back-link">← Back to tasks</a>

    {{-- Title + task ID badge --}}
    <div class="title-row">
        <div class="page-title">Edit Task</div>
        <div class="task-id-badge">#{{ $task->id }}</div>
    </div>

    <div class="form-card">

        {{--
            KEY DIFFERENCE FROM CREATE:
            1. action uses route('tasks.update', $task) — includes the task ID in the URL
            2. @method('PUT') — HTML forms can only send GET/POST.
               This hidden field tricks Laravel into treating it as PUT.
               PUT means "replace the existing item with new data".
               Laravel then runs the update() function in the controller.
        --}}
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

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
                    {{--
                        KEY DIFFERENCE FROM CREATE:
                        old('title', $task->title)
                        - First argument: read from old input (after a validation error)
                        - Second argument: $task->title — the task's current title (on first load)
                        This means the field is always pre-filled.
                    --}}
                    value="{{ old('title', $task->title) }}"
                    autofocus
                >
                @error('title')
                    <div class="field-error">✕ {{ $message }}</div>
                @enderror
            </div>

            {{-- ── DESCRIPTION ── --}}
            <div class="field">
                <label class="field-label" for="description">
                    Description <span class="optional">(optional)</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    class="field-textarea {{ $errors->has('description') ? 'is-error' : '' }}"
                    rows="4"
                >{{ old('description', $task->description) }}</textarea>
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
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{--
                                        old('category_id', $task->category_id)
                                        Pre-selects the task's current category on first load.
                                        Remembers what the user picked after a validation error.
                                    --}}
                                    @selected(old('category_id', $task->category_id) == $category->id)
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
                    {{-- Show current status as a small hint above the label --}}
                    <div class="current-status">
                        <span class="status-dot dot-{{ $task->status }}"></span>
                        Currently: {{ \App\Models\Task::STATUSES[$task->status] }}
                    </div>
                    <label class="field-label" for="status">Change Status</label>
                    <div class="select-wrap">
                        <select id="status" name="status" class="field-select">
                            @foreach ($status as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{--
                                        Pre-selects the task's current status.
                                        After a validation error, uses what the user last picked.
                                    --}}
                                    @selected(old('status', $task->status) === $value)
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
                <button type="submit" class="btn-save">Save Changes</button>
                <a href="{{ route('tasks.index') }}" class="btn-cancel">Cancel</a>
            </div>

        </form>

        {{--
            DANGER ZONE — delete from the edit page as well.
            Separate form with DELETE method.
            confirm() asks "are you sure?" before submitting.
        --}}
        <div class="danger-zone">
            <div class="danger-zone-title">Delete this task</div>
            <div class="danger-zone-sub">This action cannot be undone. The task will be permanently removed.</div>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                  onsubmit="return confirm('Delete «{{ addslashes($task->title) }}»?\nThis action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-full">Delete task permanently</button>
            </form>
        </div>

    </div>
</div>
</x-app-layout>
