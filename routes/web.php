<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('account', AccountController::class)->name('account');

Route::controller(UserController::class)->name('users.')
    ->prefix('users')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('/{user}', 'show')->name('show');
        Route::delete('delete', 'delete')->name('delete');
    });
Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::controller(GroupController::class)->name('groups.')
    ->prefix('groups')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('update/{group_id}', 'update')->name('update');
        Route::put('edit/{group_id}', 'edit')->name('edit');
        Route::delete('delete/{group_id}', 'delete')->name('delete');
    });

Route::controller(TaskController::class)->name('tasks.')
    ->prefix('{group_id}/tasks')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('{task_id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('{task_id}/edit', 'edit')->name('edit');
        Route::delete('{task_id}', 'delete')->name('delete');
    });

Route::controller(CommentController::class)->name('comments')
    ->prefix('{task_id}/comments')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::post('/', 'store');
    });