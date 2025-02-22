<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Console\Application;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(): View|Application|Factory
    {
        return view('tasks.index');
    }
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'task_list_id' => 'required|exists:task_lists,id'
        ]);

        $taskList = TaskList::findOrFail($request->task_list_id);
        $this->authorize('update', $taskList);

        $task = $taskList->tasks()->create([
            'title' => $request->title,
            'user_id' => auth()->id(),
        ]);

        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task->taskList);
        $task->update($request->only('title', 'completed'));
        return response()->json(['message' => __('messages.updated')]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task->taskList);
        $task->delete();
        return response()->json(['message' => __('messages.deleted')]);
    }
}
