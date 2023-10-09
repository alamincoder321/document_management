<?php

use App\Http\Controllers\Admin\AdminAccessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Admin Login Route
Route::group(["prefix" => "admin"], function () {
    Route::get('/', [LoginController::class, 'showAdminLoginForm'])->name('admin.login.show');
    Route::post('/', [LoginController::class, 'AdminLogin'])->name('admin.login');
    Route::post('/logout', [DashboardController::class, 'Logout'])->middleware('auth:admin')->name('admin.logout');

    // admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    //profile Route
    Route::get('/profile', [DashboardController::class, 'profileIndex'])->name('admin.profile');
    Route::post('/profile', [DashboardController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/profileImage', [DashboardController::class, 'imageUpdate'])->name('admin.profile.imageUpdate');
    
    //user Route
    Route::get('/user', [AdminAccessController::class, 'create'])->name('admin.user.create');
    Route::get('/get-user/{id?}', [AdminAccessController::class, 'index'])->name('admin.user.index');
    Route::post('/user', [AdminAccessController::class, 'store'])->name('admin.user.store');
    Route::post('/update/user', [AdminAccessController::class, 'update'])->name('admin.user.update');
    Route::post('/user/delete', [AdminAccessController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/user/permission/{id}', [AdminAccessController::class, 'permissionEdit'])->name('admin.user.permission');
    Route::post('/user/store-permission', [AdminAccessController::class, 'permissionStore'])->name('admin.store.permission');
});
