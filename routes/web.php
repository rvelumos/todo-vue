<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tasklists', [TaskListController::class, 'index'])->name('tasklists.index');
    Route::post('/tasklists', [TaskListController::class, 'store'])->name('tasklists.create');
    Route::get('/tasklists/{taskList}', [TaskListController::class, 'show'])->name('tasklists.show');
    Route::put('/tasklists/{taskList}', [TaskListController::class, 'update'])->name('tasklists.update');
    Route::delete('/tasklists/{taskList}', [TaskListController::class, 'destroy'])->name('tasklists.destroy');

    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});

