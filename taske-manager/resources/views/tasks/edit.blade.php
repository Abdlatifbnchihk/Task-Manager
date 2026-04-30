{{-- Use the shared layout --}}
@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit Task</h1>
</div>

<div class="card" style="max-width: 600px;">

    {{--
        This form sends data to the update() function in TaskController.
        The route needs the $task so Laravel knows WHICH task to update.
        route('tasks.update', $task) generates: /tasks/5 (where 5 is the task ID)
    --}}
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf

        {{--
            @method('PUT') is very important here.
            HTML forms can only send GET or POST.
            But our route expects a PUT request (meaning "replace this item").
            This hidden field tells Laravel to treat this POST as a PUT.
        --}}
        @method('PUT')

        {{-- ── TITLE FIELD — pre-filled with the task's current title ── --}}
        <div class="form-group">
            <label for="title">Title <span style="color:#dc2626;">*</span></label>
            <input
                type="text"
                id="title"
                name="title"

                {{--
                    old('title', $task->title) means:
                    - If there was a validation error, use what the user typed (old)
                    - If this is a fresh page load, use the task's current title ($task->title)
                --}}
                value="{{ old('title', $task->title) }}"

                class="{{ $errors->has('title') ? 'input-error' : '' }}"
            >

            @error('title')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── DESCRIPTION FIELD — pre-filled with current description ── --}}
        <div class="form-group">
            <label for="description">Description <span style="color:#888; font-weight:400;">(optional)</span></label>
            <textarea id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>

            @error('description')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── CATEGORY DROPDOWN — pre-selected with current category ── --}}
        <div class="form-group">
            <label for="category_id">Category <span style="color:#dc2626;">*</span></label>
            <select id="category_id" name="category_id"
                class="{{ $errors->has('category_id') ? 'input-error' : '' }}">

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{--
                            old('category_id', $task->category_id) means:
                            - After error: use what the user selected
                            - Fresh load: use the task's current category
                        --}}
                        @selected(old('category_id', $task->category_id) == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── STATUS DROPDOWN — pre-selected with current status ── --}}
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('status', $task->status) === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('status')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── SUBMIT AND CANCEL BUTTONS ── --}}
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection