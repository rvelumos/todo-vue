<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{
    public function index()
    {
        return view('tasklists.index');
    }

    public function getTaskLists(): JsonResponse
    {
        return response()->json(Auth::user()->taskLists()->with('tasks')->get());
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        return view('tasklists.index');
    }

    public function show(TaskList $taskList): TaskList
    {
        $this->authorize('view', $taskList);
        return $taskList->load('tasks');
    }

    public function update(Request $request, TaskList $tasklist)
    {
        $this->authorize('update', $tasklist);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tasklist->update(['name' => $request->name]);

        return redirect()->route('tasklists.index')->with('success', 'Tasklist bijgewerkt!');
    }


    public function destroy(TaskList $taskList): JsonResponse
    {
        $this->authorize('delete', $taskList);
        $taskList->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

