<?php

use App\Http\Controllers\Admin\ApprovalController as AdminApprovalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\LeaveController;
use App\Http\Controllers\Employee\MyProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
// commont route
Route::middleware(['auth'])->prefix('/')->group(function () {
    Route::get('/settings', [ProfileController::class, 'edit'])->name('setting.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('setting.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('setting.destroy');
});
// employee route
Route::middleware(['auth', 'role:employee'])->prefix('/employee')->name('employee.')->group(function () {
    Route::resource('/dashboard', EmployeeDashboardController::class);
    Route::resource('/my-profile', MyProfileController::class);
    Route::get('/my-leave',  [LeaveController::class, 'index'])->name('my-leave.index');
    Route::get('/apply-leave', [LeaveController::class, 'formLeave'])->name('apply-leave.index');
    Route::post('/apply-leave', [LeaveController::class, 'storeLeave'])->name('apply-leave.store');
});
// admin route
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::resource('dashboard', AdminDashboardController::class);
    Route::resource('employees', AdminEmployeeController::class);
    Route::resource('leave-requests', AdminLeaveRequestController::class);
    Route::resource('approvals', AdminApprovalController::class);
    Route::get('export', [AdminExportController::class, 'index'])->name('export.index');
    Route::get('/export/download', [AdminExportController::class, 'export'])->name('export.download');
    Route::resource('notifications', AdminNotificationController::class);
});

require __DIR__ . '/auth.php';
