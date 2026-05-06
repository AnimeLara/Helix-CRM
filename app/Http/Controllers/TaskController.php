<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use App\Support\CrmActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(protected TaskRepository $tasks)
    {
    }

    public function index(): View
    {
        return view('pages.tasks.index', [
            'tasks' => $this->tasks->list(),
            'users' => User::query()->orderBy('name')->get(),
            'customers' => Customer::query()->orderBy('name')->get(),
            'deals' => Deal::query()->orderBy('title')->get(),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload['completed_at'] = $payload['status'] === 'completed' ? now() : null;
        $payload['assigned_to'] = $payload['assigned_to'] ?? $request->user()->id;

        $task = Task::query()->create($payload);

        CrmActivity::record('task_created', "Created task {$task->title}.", $task, $request->user()->id, 'clipboard-document-list');

        return back()->with('toast', ['type' => 'success', 'message' => 'Task created successfully.']);
    }

    public function show(Task $task): View
    {
        $task->load(['assignee', 'customer', 'deal']);

        return view('pages.tasks.show', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $payload = $request->validated();
        $payload['completed_at'] = $payload['status'] === 'completed' ? now() : null;

        $task->update($payload);

        CrmActivity::record('task_updated', "Updated task {$task->title}.", $task, $request->user()->id, 'pencil-square');

        return back()->with('toast', ['type' => 'success', 'message' => 'Task updated successfully.']);
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $title = $task->title;
        $task->delete();

        CrmActivity::record('task_deleted', "Removed task {$title}.", null, $request->user()->id, 'trash');

        return back()->with('toast', ['type' => 'success', 'message' => 'Task deleted successfully.']);
    }

    public function complete(Request $request, Task $task): RedirectResponse
    {
        $task->markComplete();

        CrmActivity::record('task_completed', "Completed task {$task->title}.", $task, $request->user()->id, 'check-circle');

        return back()->with('toast', ['type' => 'success', 'message' => 'Task marked complete.']);
    }
}
