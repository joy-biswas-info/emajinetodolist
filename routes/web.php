<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware('admin')->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/', [TaskController::class, 'index']);
    Route::post('/tasks/update-order', [TaskController::class, 'updateOrder']);
    Route::post('/tasks', [TaskController::class, 'store'])->name('add.task');
    Route::post('/tasks/toggle-completion/{id}', [TaskController::class, 'toggleCompletion']);
    Route::post('/upload-temp-image', [TempImageController::class, 'index'])->name('temp-images.create');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';