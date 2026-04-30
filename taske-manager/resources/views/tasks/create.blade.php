{{-- Use the shared layout --}}
@extends('layouts.app')

@section('title', 'New Task')

@section('content')

<div class="page-header">
    <h1 class="page-title">New Task</h1>
</div>

<div class="card" style="max-width: 600px;">

    {{--
        The form sends data to the store() function in TaskController.
        method="POST" means we are sending data to be saved.
        action="{{ route('tasks.store') }}" is the URL that receives the data.
    --}}
    <form method="POST" action="{{ route('tasks.store') }}">

        {{--
            @csrf adds a hidden secret token inside the form.
            Laravel checks this token on every form submission to make sure
            the request is real and not sent by a hacker from another website.
            Without @csrf, Laravel will reject the form with a 419 error.
        --}}
        @csrf

        {{-- ── TITLE FIELD ── --}}
        <div class="form-group">
            <label for="title">Title <span style="color:#dc2626;">*</span></label>
            <input
                type="text"
                id="title"
                name="title"
                placeholder="What needs to be done?"

                {{--
                    old('title') keeps the value the user typed if the form
                    was rejected due to a validation error.
                    Without this, the field would be blank after an error.
                --}}
                value="{{ old('title') }}"

                {{-- Add red border if this field has a validation error --}}
                class="{{ $errors->has('title') ? 'input-error' : '' }}"
            >

            {{--
                @error('title') checks if the 'title' field failed validation.
                $message contains the error text, like "The title field is required."
            --}}
            @error('title')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── DESCRIPTION FIELD ── --}}
        <div class="form-group">
            <label for="description">Description <span style="color:#888; font-weight:400;">(optional)</span></label>
            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="Add more details..."
            >{{ old('description') }}</textarea>

            @error('description')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── CATEGORY DROPDOWN ── --}}
        <div class="form-group">
            <label for="category_id">Category <span style="color:#dc2626;">*</span></label>
            <select id="category_id" name="category_id"
                class="{{ $errors->has('category_id') ? 'input-error' : '' }}">

                <option value="">-- Choose a category --</option>

                {{--
                    $categories was sent from the controller's create() function.
                    We loop through each one and make it an <option>.
                    old('category_id') re-selects the same option after an error.
                --}}
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- ── STATUS DROPDOWN ── --}}
        <div class="form-group">
            <label for="status">Initial Status</label>
            <select id="status" name="status">

                {{--
                    $statuses = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'completed' => 'Completed']
                    $value is the key (todo), $label is the display text (To Do)
                    The default selected is 'todo'
                --}}
                @foreach ($status as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('status', 'todo') === $value)
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
            <button type="submit" class="btn btn-primary">Save Task</button>

            {{-- Cancel goes back to the task list without saving anything --}}
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection