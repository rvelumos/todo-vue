<?php

namespace App\Http\Controllers;

use App\Models\TaskList;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{

    use AuthorizesRequests;

    public function index(): View|Application|Factory
    {
        return view('tasklists.index');
    }

    public function getTaskLists(): JsonResponse
    {
        return response()->json(Auth::user()->taskLists()->with('tasks')->get());
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Auth::user()->taskLists()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('tasklists.index')->with('success', __('messages.task_list_created'));
    }

    public function show(TaskList $taskList): TaskList
    {
        $this->authorize('view', $taskList);
        return $taskList->load('tasks');
    }

    public function update(Request $request, TaskList $tasklist): RedirectResponse
    {
        $this->authorize('update', $tasklist);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tasklist->update(['name' => $request->name]);

        return redirect()->route('tasklists.index')->with('success', __('messages.task_list_updated'));
    }


    public function destroy(TaskList $taskList): JsonResponse
    {
        $this->authorize('delete', $taskList);
        $taskList->delete();
        return response()->json(['message' => __('messages.task_list_deleted')]);
    }
}

