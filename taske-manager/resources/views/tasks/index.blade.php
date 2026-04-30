{{--
    @extends means: use the layout file as the base wrapper.
    Everything in this file goes INSIDE that layout.
--}}
<x-app-layout title="">

{{--
    @section('title') fills the @yield('title') slot in the layout.
    This sets the browser tab title.
--}}


{{--
    @section('content') fills the @yield('content') slot in the layout.
    Everything between here and @endsection is the actual page content.
--}}

{{-- ── Page header: title on the left, "New Task" button on the right ── --}}
<div class="page-header">
    <h1 class="page-title">My Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
</div>

{{--
    FILTER BAR (US8 and US9)
    method="GET" means the filter values are added to the URL
    like: /tasks?status=todo&category_id=2
    The controller reads these values from $request.
--}}
<form method="GET" action="{{ route('tasks.index') }}" class="filter-bar">

    {{-- Filter by status --}}
    <select name="status">
        <option value="">All statuses</option>

        {{--
            Loop through Task::STATUSES which is:
            ['todo' => 'To Do', 'in_progress' => 'In Progress', 'completed' => 'Completed']
            $value = 'todo'      $label = 'To Do'
        --}}
        @foreach (\App\Models\Task::STATUSES as $value => $label)
            <option value="{{ $value }}"

                {{--
                    @selected checks if this option matches what the user picked.
                    request('status') reads the value from the URL.
                    If they match, the dropdown shows this option as selected.
                --}}
                @selected(request('status') === $value)
            >
                {{ $label }}
            </option>
        @endforeach
    </select>

    {{-- Filter by category --}}
    <select name="category_id">
        <option value="">All categories</option>

        {{--
            $categories was sent from the controller's index() function.
            We loop through each category and make it an option.
        --}}
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected(request('category_id') == $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    {{-- Submit the filter form --}}
    <button type="submit" class="btn btn-secondary">Filter</button>

    {{-- Reset link — goes to /tasks with no filters --}}
    <a href="{{ route('tasks.index') }}" style="font-size:13px; color:#888; text-decoration:none;">
        Reset
    </a>
</form>

{{-- ── Task table ── --}}
<div class="card" style="padding: 0; overflow: hidden;">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        {{--
            @forelse is like @foreach but it has an @empty block.
            If $tasks is empty, it shows the "no tasks" message instead.
            $tasks was sent from the controller's index() function.
        --}}
        @forelse ($tasks as $task)
            <tr>
                {{-- Task title --}}
                <td>
                    <span style="font-weight:500;">{{ $task->title }}</span>
                    @if ($task->description)
                        {{-- Show a short preview of the description --}}
                        <br>
                        <span style="font-size:12px; color:#888;">
                            {{ Str::limit($task->description, 60) }}
                        </span>
                    @endif
                </td>

                {{-- Category name — $task->category works because of the belongsTo relationship --}}
                <td>{{ $task->category->name ?? '—' }}</td>

                {{--
                    Status badge — the CSS class changes color based on status value.
                    badge-todo = grey, badge-in_progress = blue, badge-completed = green
                --}}
                <td>
                    <span class="badge badge-{{ $task->status }}">
                        {{ \App\Models\Task::STATUSES[$task->status] }}
                    </span>
                </td>

                {{-- Format the created_at date nicely --}}
                <td style="color:#888; font-size:13px;">
                    {{ $task->created_at->format('d M Y') }}
                </td>

                {{-- Action buttons for each task row --}}
                <td>
                    <div style="display:flex; gap:6px; align-items:center;">

                        {{--
                            QUICK STATUS BUTTON (US7)
                            This is a small form that sends a PATCH request.
                            PATCH means "update only one part of something".
                            Clicking it moves the status one step forward.
                        --}}
                        <form method="POST" action="{{ route('tasks.status', $task) }}">
                            @csrf
                            @method('PATCH') {{-- This tells Laravel it is a PATCH request, not POST --}}
                            <button type="submit" class="btn btn-warning btn-sm"
                                title="Move to: {{ \App\Models\Task::STATUSES[$task->nextStatus()] }}">
                                → {{ \App\Models\Task::STATUSES[$task->nextStatus()] }}
                            </button>
                        </form>

                        {{-- Edit button — goes to the edit form for this task --}}
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary btn-sm">
                            Edit
                        </a>

                        {{--
                            DELETE BUTTON (US6)
                            Uses a form because DELETE is not a normal link action.
                            onsubmit="return confirm(...)" shows a popup asking "are you sure?".
                            If the user clicks Cancel, the form is NOT submitted.
                        --}}
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                              onsubmit="return confirm('Delete this task? This cannot be undone.')">
                            @csrf
                            @method('DELETE') {{-- Tells Laravel this is a DELETE request --}}
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                    </div>
                </td>
            </tr>

        {{-- @empty runs when $tasks has zero items --}}
        @empty
            <tr>
                <td colspan="5">
                    <div class="empty">
                        <p>You have no tasks yet.</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create your first task</a>
                    </div>
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>



</x-app-layout>