<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// FRONTEND ROUTES (Publik)
// ==========================================
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::post('/order', [FrontController::class, 'storeOrder'])->name('order.store');

// ==========================================
// ADMIN DASHBOARD ROUTES (Protected by Auth)
// ==========================================
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Portofolio
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects.index');
    Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}/images', [AdminController::class, 'destroyProjectImage'])->name('projects.images.destroy');
    Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');

    // View Orders / Leads
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');

});

// ==========================================
// PROFILE ROUTES (Bawaan Breeze)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load file routing autentikasi bawaan Laravel Breeze (login, logout, dll)
require __DIR__.'/auth.php';
