<?php

use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\AdminPageController;
use Illuminate\Support\Facades\Route;

# Public pages (guest)
Route::middleware('guest')->group(function () {
    Route::get('/', function(){ return redirect()->route('login.form'); });
    Route::get('/register', [PublicPageController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [PublicPageController::class, 'register'])->name('register.submit');
    Route::get('/login', [PublicPageController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [PublicPageController::class, 'login'])->name('login.submit');
});

# Public pages (auth)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [PublicPageController::class, 'logout'])->name('logout');
    Route::get('/profile', [PublicPageController::class, 'profile'])->name('profile');

    Route::get('/submissions', [PublicPageController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/create', [PublicPageController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [PublicPageController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{id}', [PublicPageController::class, 'show'])->name('submissions.show');
});

# Admin pages
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function(){
        Route::get('/login', [AdminPageController::class, 'showLoginForm'])->name('admin.login.form');
        Route::post('/login', [AdminPageController::class, 'login'])->name('admin.login.submit');
    });

    Route::middleware(['auth','admin'])->group(function(){
        Route::post('/logout', [AdminPageController::class, 'logout'])->name('admin.logout');
        Route::get('/submissions', [AdminPageController::class, 'index'])->name('admin.submissions.index');
        Route::get('/submissions/{id}', [AdminPageController::class, 'show'])->name('admin.submissions.show');
        Route::patch('/submissions/{id}/status', [AdminPageController::class, 'updateStatus'])->name('admin.submissions.updateStatus');
    });
});


