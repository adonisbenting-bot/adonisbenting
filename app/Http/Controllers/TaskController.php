<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * View Tasks - Display all saved tasks.
     */
    public function index(): View
    {
        $tasks = Schema::hasTable('tasks') ? Task::latest()->get() : collect();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Add Task - Store a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedTaskData($request);
        $validated['status'] = $validated['status'] ?? 'Pending';

        Task::create($validated);

        return redirect()->route('home');
    }

    /**
     * Edit Task - Display form to edit existing task.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Edit Task - Update task information.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validatedTaskData($request));

        return redirect()->route('home');
    }

    /**
     * Update Status - Toggle or switch between Pending and Completed.
     */
    public function updateStatus(Task $task): RedirectResponse
    {
        $newStatus = ($task->status === 'Completed' || $task->status === 'completed') ? 'Pending' : 'Completed';
        $task->update(['status' => $newStatus]);

        return redirect()->route('home');
    }

    /**
     * Delete Task - Remove a task.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('home');
    }

    /**
     * Form Validation Rules
     */
    private function validatedTaskData(Request $request): array
    {
        return $request->validate([
            'task_name'   => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date'    => ['nullable', 'date'],
            'status'      => ['nullable', 'string', 'in:Pending,Completed,pending,completed'],
        ]);
    }
}