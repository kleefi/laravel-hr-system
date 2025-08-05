<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
// employee route
Route::middleware('auth')->prefix('/')->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::get('/settings', [ProfileController::class, 'edit'])->name('setting.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('setting.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('setting.destroy');
});
// admin route
require __DIR__ . '/auth.php';
