<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\manager\ManagerProjectController;
use App\Http\Controllers\manager\ManagerTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TempImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/upload-temp-image', [TempImageController::class, 'index'])->name('temp-images.create');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('admin')->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('manager')->group(function () {
    Route::get('/projects', [ManagerProjectController::class, 'index'])->name('project.index');
    Route::get('/add-task/{project}', [ManagerTaskController::class, 'create'])->name('manager.task.add');
    Route::get('/delete-task/{task}', [ManagerTaskController::class, 'distroy'])->name('manager.task.delete');
    Route::post('/tasks/update-order', [ManagerTaskController::class, 'updateOrder']);
    Route::post('/tasks', [ManagerTaskController::class, 'store'])->name('manager.add.task');
    Route::post('/tasks/toggle-completion/{id}', [ManagerTaskController::class, 'toggleCompletion']);
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';