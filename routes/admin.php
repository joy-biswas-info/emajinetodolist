<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\TempImageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authentication', [AdminLoginController::class, 'authenticate'])->name('admin.authentication');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');
        Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/create-project', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/create-project', [ProjectController::class, 'store'])->name('project.store');
        Route::delete('/projects/{project}', [ProjectController::class, 'distroy'])->name('project.delete');

        Route::get('/users', [UserController::class, 'index'])->name('user.index');

        Route::post('/upload-temp-image', [TempImageController::class, 'index'])->name('temp-images.create');
        // Task Routes 
        Route::get('/add-task/{project}', [TaskController::class, 'create'])->name('task.add');
        Route::get('/delete-task/{task}', [TaskController::class, 'distroy'])->name('task.delete');
        Route::post('/tasks/update-order', [TaskController::class, 'updateOrder']);
        Route::post('/tasks', [TaskController::class, 'store'])->name('add.task');
        Route::post('/tasks/toggle-completion/{id}', [TaskController::class, 'toggleCompletion']);
        Route::post('/upload-temp-image', [TempImageController::class, 'index'])->name('temp-images.create');


        Route::delete('/delete-user/{user}', [UserController::class, 'distroy'])->name('delete.user');
    });
});