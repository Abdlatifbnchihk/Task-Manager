<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //

    private function authorizeOwnership(Task $task){
        if($task->user_id != auth()->id){
            abort(403, 'Unauthorized action.');
        }
    }

    // handel category and show all
    public function index(Request $request) {
        $query = auth()->user()->tasks()->with("Category");

        if($request->filled("status")) {
            $query->where("status", $request->status);
        }

        if($request->filled("category_id")) {
            $query->where("category_id", $request->category);
        }

        $tasks = $query->latest()->get();
        $categories = Category::orderBy("name")->get();

        return view("tasks.index", compact("tasks", "categories"));
    }

    public function create() {
        $categories = Category::orderBy("name")->get();
        $status = Task::STATUSES;

        return view("/tasks/create", compact("categories","status"));
    }

    public function store(Request $request){
        $valideted = $request->validate([
            'title'         =>  'required|string|max:255',
            'description'   =>  'nullable|string',
            'category_id'   =>  'required|exists:categories,id',
            'status'        =>  'required|in:todo,in_progress,completed',
        ]);

        auth()->user()->tasks()->create($valideted);

        return redirect()->route('tasks.index')->with('success','Task created successfully.');
    }

    public function edit(Task $task){
        $this->authorizeOwnership($task);

        $categories = Category::orderBy('name')->get();
        $status = Task::STATUSES;

        return view('tasks.edit', compact('task','status', 'categories'));
    }

    public function update(Request $request, Task $task) {
        $this->authorizeOwnership($task);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:todo,in_progress,completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success','Task updated successfully.');
    }

    public function destroy(Task $task){
        $this->authorizeOwnership($task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success','Task deleted');
    }

    public function updateStatus(Task $task){
        $this->authorizeOwnership($task);

        $task->update(['status' => $task->nextStatus()]);

        return back()->with('success', 'Status updated.');
    }

}
