{{--
@extends means: use the layout file as the base wrapper.
Everything in this file goes INSIDE that layout.
--}}
<x-app-layout title="">
    {{-- ═══════════════════════════════════════════════════
    index.blade.php — Task list page
    Shows all the logged-in user's tasks in a table.
    Top section: title + New Task button.
    Below: filter bar for status and category.
    Table: title, category, status badge, date, actions.
    ════════════════════════════════════════════════════ --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --bg: #F7F7F5;
            --surface: #FFFFFF;
            --border: #E8E8E4;
            --text: #1C1C1A;
            --muted: #888884;
            --accent: #1C1C1A;
            --accent-fg: #FFFFFF;
            --radius: 10px;
            --font: 'DM Sans', sans-serif;
            --mono: 'DM Mono', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .pg {
            background: var(--bg);
            min-height: 100vh;
            padding: 36px 90px;
            font-family: var(--font);
        }

        /* ── Flash ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 9px;
            background: #EDFAF3;
            color: #1A6B3E;
            border: 1.5px solid #C2EDDA;
            padding: 11px 15px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-title {
            font-size: 27px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .page-sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 5px;
        }

        /* New task button */
        .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            /* background: var(--accent); */
            color: var(--accent-fg);
            padding: 10px 18px;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 500;
            font-family: var(--font);
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-new:hover {
            opacity: .82;
        }

        /* ── Filters ── */
        .filters {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .fselect {
            height: 38px;
            padding: 0 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: var(--font);
            color: var(--text);
            background: var(--surface);
            outline: none;
            cursor: pointer;
            transition: border-color .15s;
        }

        .fselect:focus {
            border-color: var(--accent);
        }

        .btn-filter {
            height: 38px;
            padding: 0 16px;
            /* background: var(--accent); */
            color: var(--accent-fg);
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-family: var(--font);
            font-weight: 500;
            cursor: pointer;
            transition: opacity .15s;
        }

        .btn-filter:hover {
            opacity: .82;
        }

        .btn-clear {
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
            padding: 0 4px;
        }

        .btn-clear:hover {
            color: var(--text);
        }

        /* ── Count line ── */
        .count-line {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .count-line strong {
            color: var(--text);
            font-weight: 600;
        }

        /* ── Card wrapper ── */
        .card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        /* ── Table ── */
        .tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl thead tr {
            border-bottom: 1.5px solid var(--border);
        }

        .tbl th {
            padding: 11px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 500;
            font-family: var(--mono);
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .07em;
            white-space: nowrap;
        }

        .tbl tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        .tbl tbody tr:last-child {
            border-bottom: none;
        }

        .tbl tbody tr:hover {
            background: #FAFAF8;
        }

        .tbl td {
            padding: 14px 16px;
            font-size: 14px;
            color: var(--text);
            vertical-align: middle;
        }

        /* ── Task cell ── */
        .task-name {
            font-weight: 500;
        }

        .task-desc {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* ── Category pill ── */
        .cat {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 5px;
            background: #F0F0EC;
            color: #555550;
            font-size: 12px;
            font-weight: 500;
            font-family: var(--mono);
        }

        /* ── Status badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-todo {
            background: #F3F3F0;
            color: #777772;
        }

        .badge-todo::before {
            background: #AAAAA5;
        }

        .badge-in_progress {
            background: #EBF3FF;
            color: #1A5FAD;
        }

        .badge-in_progress::before {
            background: #3B82F6;
        }

        .badge-completed {
            background: #EAFAF0;
            color: #1A7040;
        }

        .badge-completed::before {
            background: #22C55E;
        }

        /* ── Date ── */
        .date {
            font-size: 12px;
            color: var(--muted);
            font-family: var(--mono);
            white-space: nowrap;
        }

        /* ── Action buttons ── */
        .actions {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .abtn {
            height: 30px;
            padding: 0 11px;
            border-radius: 6px;
            font-size: 12px;
            font-family: var(--font);
            font-weight: 500;
            border: 1.5px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            transition: all .12s;
        }

        /* quick status */
        .abtn-status {
            background: #F0F0EC;
            color: var(--text);
            border-color: var(--border);
        }

        .abtn-status:hover {
            background: var(--accent);
            color: var(--accent-fg);
            border-color: var(--accent);
        }

        /* edit */
        .abtn-edit {
            background: var(--surface);
            color: var(--text);
            border-color: var(--border);
        }

        .abtn-edit:hover {
            background: #F5F5F2;
            border-color: #CCCCC8;
        }

        /* delete */
        .abtn-delete {
            background: var(--surface);
            color: #BB2222;
            border-color: #FFE0E0;
        }

        .abtn-delete:hover {
            background: #FFF2F2;
            border-color: #FFB8B8;
        }

        /* ── Empty state ── */
        .empty {
            text-align: center;
            padding: 64px 24px;
        }

        .empty-icon {
            font-size: 32px;
            opacity: .25;
            margin-bottom: 12px;
        }

        .empty-title {
            font-size: 16px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 20px;
        }

        /* ── Row animation ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tbl tbody tr {
            animation: fadeUp .22s ease both;
        }

        .tbl tbody tr:nth-child(1) {
            animation-delay: .03s
        }

        .tbl tbody tr:nth-child(2) {
            animation-delay: .06s
        }

        .tbl tbody tr:nth-child(3) {
            animation-delay: .09s
        }

        .tbl tbody tr:nth-child(4) {
            animation-delay: .12s
        }

        .tbl tbody tr:nth-child(5) {
            animation-delay: .15s
        }

        .tbl tbody tr:nth-child(n+6) {
            animation-delay: .17s
        }

        /* ── Stat cards row ── */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        /* Base card style */
        .stat-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: relative;
            overflow: hidden;
            transition: border-color .15s, box-shadow .15s;
        }

        /* Clickable cards get a hover effect */
        a.stat-card:hover {
            border-color: #CCCCC8;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        /* The big number */
        .stat-number {
            font-size: 28px;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
            font-family: var(--mono);
        }

        /* The label below the number */
        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        /* Colored dot in the corner — decoration */
        .stat-dot {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .dot-todo {
            background: #AAAAA5;
        }

        .dot-ip {
            background: #3B82F6;
        }

        .dot-done {
            background: #22C55E;
        }

        .dot-total {
            background: var(--border);
        }

        /* Active state — when this card's filter is currently applied */
        .stat-active {
            border-color: var(--accent) !important;
            background: #FAFAF8;
        }

        .stat-active .stat-number {
            color: var(--accent);
        }

        .stat-active .stat-label {
            color: var(--text);
        }

        /* Color tints per card */
        .stat-todo .stat-number {
            color: #777772;
        }

        .stat-ip .stat-number {
            color: #1A5FAD;
        }

        .stat-done .stat-number {
            color: #1A7040;
        }
    </style>

    <div class="pg">

        {{-- Flash message from controller e.g. ->with('success','Task created!') --}}
        @if (session('success'))
            <div class="flash">✓ {{ session('success') }}</div>
        @endif

        {{-- Page title + New Task button --}}
        <div class="topbar">
            <div>
                <div class="page-title">My Tasks</div>
                <div class="page-sub">Welcome back, {{ auth()->user()->name }}</div>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn-new bg-indigo-600">
                + &nbsp;New Task
            </a>
        </div>

        {{--
        FILTER FORM (US8 + US9)
        method="GET" puts filters in the URL: /tasks?status=todo&category_id=2
        The controller index() reads them with $request->status and $request->category_id
        --}}
        <form method="GET" action="{{ route('tasks.index') }}" class="filters">

            <select name="status" class="fselect">
                <option value="">All statuses</option>
                {{-- Task::STATUSES = ['todo'=>'To Do','in_progress'=>'In Progress','completed'=>'Completed'] --}}
                @foreach (\App\Models\Task::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select name="category_id" class="fselect">
                <option value="">All categories</option>
                {{-- $categories sent from the controller's index() function --}}
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-filter bg-indigo-600">Filter</button>

            {{-- Only show the clear link when a filter is active --}}
            @if (request('status') || request('category_id'))
                <a href="{{ route('tasks.index') }}" class="btn-clear">✕ Clear</a>
            @endif

        </form>

        {{-- Show how many tasks are currently displayed --}}
        <div class="count-line">
            <strong>{{ $tasks->count() }}</strong>
            task{{ $tasks->count() !== 1 ? 's' : '' }}
            @if(request('status') || request('category_id')) — filtered @endif
        </div>

        {{-- ── STATUS COUNTS ── --}}
        {{-- $counts was sent from the controller's index() function --}}
        {{-- Each card is also a clickable filter shortcut --}}

        <div class="stat-row">

            {{-- TO DO card --}}
            <a href="{{ route('tasks.index', ['status' => 'todo']) }}"
                class="stat-card stat-todo {{ request('status') === 'todo' ? 'stat-active' : '' }}">
                <div class="stat-number">{{ $counts['todo'] }}</div>
                <div class="stat-label">To Do</div>
                <div class="stat-dot dot-todo"></div>
            </a>

            {{-- IN PROGRESS card --}}
            <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
                class="stat-card stat-ip {{ request('status') === 'in_progress' ? 'stat-active' : '' }}">
                <div class="stat-number">{{ $counts['in_progress'] }}</div>
                <div class="stat-label">In Progress</div>
                <div class="stat-dot dot-ip"></div>
            </a>

            {{-- COMPLETED card --}}
            <a href="{{ route('tasks.index', ['status' => 'completed']) }}"
                class="stat-card stat-done {{ request('status') === 'completed' ? 'stat-active' : '' }}">
                <div class="stat-number">{{ $counts['completed'] }}</div>
                <div class="stat-label">Completed</div>
                <div class="stat-dot dot-done"></div>
            </a>

            {{-- TOTAL card — not clickable, just informational --}}
            <div class="stat-card stat-total">
                <div class="stat-number">
                    {{ $counts['todo'] + $counts['in_progress'] + $counts['completed'] }}
                </div>
                <div class="stat-label">Total Tasks</div>
                <div class="stat-dot dot-total"></div>
            </div>

        </div>

        {{-- Main table card --}}
        <div class="card">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($tasks as $task)
                        <tr>
                            {{-- Title + description preview --}}
                            <td>
                                <div class="task-name">{{ $task->title }}</div>
                                @if ($task->description)
                                    <div class="task-desc">{{ Str::limit($task->description, 55) }}</div>
                                @endif
                            </td>

                            {{-- Category name via Eloquent relationship --}}
                            <td>
                                <span class="cat">{{ $task->category->name ?? '—' }}</span>
                            </td>

                            {{--
                            Status badge.
                            class="badge badge-todo" (grey)
                            class="badge badge-in_progress" (blue)
                            class="badge badge-completed" (green)
                            Task::STATUSES converts 'in_progress' → 'In Progress'
                            --}}
                            <td>
                                <span class="badge badge-{{ $task->status }}">
                                    {{ \App\Models\Task::STATUSES[$task->status] }}
                                </span>
                            </td>

                            {{-- Carbon format: 2025-01-15 → 15 Jan 2025 --}}
                            <td class="date">{{ $task->created_at->format('d M Y') }}</td>

                            <td>
                                <div class="actions">

                                    {{--
                                    QUICK STATUS (US7)
                                    PATCH /tasks/{task}/status
                                    nextStatus() in Task model returns the next status in the cycle
                                    --}}
                                    <form method="POST" action="{{ route('tasks.status', $task) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="abtn abtn-status"
                                            title="Move to: {{ \App\Models\Task::STATUSES[$task->nextStatus()] }}">
                                            → {{ \App\Models\Task::STATUSES[$task->nextStatus()] }}
                                        </button>
                                    </form>

                                    {{-- Edit: GET /tasks/{task}/edit --}}
                                    <a href="{{ route('tasks.edit', $task) }}" class="abtn abtn-edit">Edit</a>

                                    {{--
                                    DELETE (US6)
                                    confirm() shows a JS popup. Cancel = form not submitted.
                                    @method('DELETE') tells Laravel to run destroy()
                                    --}}
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                        onsubmit="return confirm('Delete «{{ addslashes($task->title) }}»?\nThis cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="abtn abtn-delete">Delete</button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty">
                                    <div class="empty-icon">✓</div>
                                    <div class="empty-title">
                                        @if(request('status') || request('category_id'))
                                            No tasks match your filters
                                        @else
                                            No tasks yet
                                        @endif
                                    </div>
                                    <div class="empty-sub">
                                        @if(request('status') || request('category_id'))
                                            Try removing the filters to see all tasks.
                                        @else
                                            Create your first task to get started.
                                        @endif
                                    </div>
                                    @if(request('status') || request('category_id'))
                                        <a href="{{ route('tasks.index') }}" class="btn-new"
                                            style="display:inline-flex;margin:0 auto;">Clear filters</a>
                                    @else
                                        <a href="{{ route('tasks.create') }}" class="btn-new"
                                            style="display:inline-flex;margin:0 auto;">+ &nbsp;New Task</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>