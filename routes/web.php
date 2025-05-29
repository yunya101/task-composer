<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserInGroup;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard')->middleware(['auth', 'verified']);
Route::view('home', 'home')->middleware('guest')->name('home');
Route::get('account', AccountController::class)->name('account');

Route::controller(UserController::class)->name('users.')
    ->prefix('users')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/{user}', 'show')->name('show');
        Route::delete('delete', 'delete')->name('delete');
    });
Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::controller(GroupController::class)->name('groups.')
    ->prefix('groups')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('{group}', 'show')->name('show')->middleware(EnsureUserInGroup::class);
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('update/{group}', 'update')->name('update')->middleware(EnsureUserInGroup::class);
        Route::put('edit/{group}', 'edit')->name('edit')->middleware(EnsureUserInGroup::class);
        Route::delete('delete/{group}', 'delete')->name('delete')->middleware(EnsureUserInGroup::class);
    });

Route::controller(TaskController::class)->name('tasks.')
    ->prefix('{group}/tasks')
    ->middleware(['auth', 'verified', EnsureUserInGroup::class])
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{task}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('{task}/edit', 'edit')->name('edit');
        Route::delete('{task}', 'delete')->name('delete');
    });

Route::controller(CommentController::class)->name('comments')
    ->prefix('{group}/tasks/{task_id}/comments')
    ->middleware(['auth', 'verified', EnsureUserInGroup::class])
    ->group(function () {
        Route::post('/', 'store');
    });

Route::controller(AuthController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('login', 'login')->name('login');
        Route::get('register', 'register')->name('register');
        Route::post('authentication', 'authentication')->name('authentication');
    });
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::controller(NotificationController::class)->name('notifications.')
    ->middleware(['auth', 'verified'])
    ->prefix('notifications')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::post('accept/{group}', 'accept')->name('accept');
        Route::post('reject/{group}', 'reject')->name('reject');
    });

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function () {
    Auth::user()->sendEmailVerificationNotification();
    return back()->with('message', 'Ссылка была отправлена!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');