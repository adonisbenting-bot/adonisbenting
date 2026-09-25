<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'index'])->name('home');

// Resource routes for index, store, update, destroy
Route::resource('tasks', TaskController::class);

// Dedicated route to update task status (Pending / Completed)
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');