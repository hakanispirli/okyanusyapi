<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\PolicyController;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hakkimizda', [AboutController::class, 'index'])->name('about');
Route::get('/hizmetlerimiz', [ServiceController::class, 'index'])->name('services');
Route::get('/hizmetlerimiz/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/uygulamalar', [BlogController::class, 'index'])->name('blogs');
Route::get('/uygulamalar/kategori/{category}', [BlogController::class, 'category'])->name('blogs.category');
Route::get('/uygulamalar/etiket/{tag}', [BlogController::class, 'tag'])->name('blogs.tag');
Route::get('/uygulamalar/{blog}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/iletisim', [ContactController::class, 'index'])->name('contact');
Route::post('/iletisim', [ContactController::class, 'store'])->name('contact.store');

// Policy Routes
Route::get('/gizlilik-politikasi', [PolicyController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/cerez-politikasi', [PolicyController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/kullanim-sartlari', [PolicyController::class, 'termsConditions'])->name('terms-conditions');

// Auth Routes
require __DIR__.'/auth.php';

// Admin Routes
require __DIR__.'/admin.php';
