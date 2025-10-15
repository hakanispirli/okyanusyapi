<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SmtpController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteInformationController;
use App\Http\Controllers\Admin\BlogCategoryController;

// Admin Routes - Require Authentication & Admin Access
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Site Information
    Route::resource('site-information', SiteInformationController::class);

    // Services
    Route::resource('services', ServiceController::class);

    // Blog Categories
    Route::resource('blog-categories', BlogCategoryController::class);

    // Blogs
    Route::resource('blogs', BlogController::class);

    // Brands
    Route::resource('brands', BrandController::class);

    // SMTP Settings
    Route::resource('smtp', SmtpController::class);
    Route::post('smtp/{smtp}/activate', [SmtpController::class, 'activate'])->name('smtp.activate');
    Route::post('smtp/{smtp}/test', [SmtpController::class, 'test'])->name('smtp.test');

});
