<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->latest()
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'pendingCount' => $tasks->where('status', 'Pending')->count(),
            'completedCount' => $tasks->where('status', 'Completed')->count(),
        ]);
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validatedTask($request));

        return to_route('tasks.index')->with('success', 'Task added to your list.');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validatedTask($request));

        return to_route('tasks.index')->with('success', 'Task details updated.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return to_route('tasks.index')->with('success', 'Task removed.');
    }

    public function updateStatus(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->status === 'Pending' ? 'Completed' : 'Pending',
        ]);

        return to_route('tasks.index')->with('success', $task->status === 'Completed'
            ? 'Nice work. Task marked completed.'
            : 'Task moved back to pending.');
    }

    /** @return array{task_name: string, description: ?string, status: string, due_date: ?string} */
    private function validatedTask(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:Pending,Completed'],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}