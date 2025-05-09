<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class)->middleware('auth');
Route::post('tasks/completed', [TaskController::class, 'fetchCompletedTasks'])->name('tasks.fetchCompleted')->middleware('auth');
Route::post('tasks/not_completed', [TaskController::class, 'fetchNotCompletedTasks'])->name('tasks.fetchNotCompleted')->middleware('auth');
Route::patch('tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete')->middleware('auth');
Route::patch('tasks/{task}/uncomplete', [TaskController::class, 'markAsNotCompleted'])->name('tasks.uncomplete')->middleware('auth');
