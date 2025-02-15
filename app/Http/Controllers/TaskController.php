<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'task_list_id' => 'required|exists:task_lists,id']);

        $taskList = TaskList::findOrFail($request->task_list_id);
        $this->authorize('update', $taskList);

        return $taskList->tasks()->create($request->only('title'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->taskList);
        $task->update($request->only('title', 'completed'));
        return response()->json(['message' => 'Updated']);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->taskList);
        $task->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

