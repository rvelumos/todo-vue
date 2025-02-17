<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasklists', [TaskListController::class, 'getTaskLists']);
    Route::post('/tasklists', [TaskListController::class, 'store'])->name('tasklists.create');
    Route::put('/tasklists/{taskList}', [TaskListController::class, 'update'])->name('tasklists.update');
    Route::delete('/tasklists/{taskList}', [TaskListController::class, 'destroy'])->name('tasklists.destroy');

    Route::get('/tasks', [TaskController::class, 'store'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.create');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
