<?php

use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\AdminPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController as WebAuth;
use App\Http\Controllers\Web\SubmissionController as WebSubmission;
use App\Http\Controllers\Web\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Web\Admin\SubmissionController as AdminSubmission;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [WebAuth::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuth::class, 'login']);
Route::post('/logout', [WebAuth::class, 'logout'])->name('logout');

Route::get('/register', [WebAuth::class, 'showRegisterForm'])->name('register');
Route::post('/register', [WebAuth::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [WebSubmission::class, 'index'])->name('dashboard');
    Route::get('/submissions/create', [WebSubmission::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [WebSubmission::class, 'store'])->name('submissions.store');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuth::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuth::class, 'login']);
    Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [AdminSubmission::class, 'index'])->name('admin.dashboard');
        Route::get('/submissions/{id}', [AdminSubmission::class, 'show'])->name('admin.submissions.show');
        Route::patch('/submissions/{id}/status', [AdminSubmission::class, 'updateStatus'])->name('admin.submissions.updateStatus');
    });
});
