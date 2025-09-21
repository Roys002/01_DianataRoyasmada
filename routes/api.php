<?php

use App\Http\Controllers\Api\AuthController as PublicAuth;
use App\Http\Controllers\Api\SubmissionController as PublicSubmission;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Api\Admin\SubmissionController as AdminSubmission;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
| Public routes
*/

Route::post('/register', [PublicAuth::class, 'register']);
Route::post('/login', [PublicAuth::class, 'login']);
Route::post('/logout', [PublicAuth::class, 'logout'])->middleware('auth:sanctum');
// Route::post('/admin/logout', [AdminAuth::class, 'logout'])->middleware(['auth:sanctum', 'admin']);
// For submission actions we require auth (so users register/login first)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', function (Request $r) {
        return $r->user();
    });
    Route::get('/profile', [PublicAuth::class, 'profile']);
    Route::apiResource('submissions', PublicSubmission::class)->only(['index', 'store', 'show']);
});


/*
| Admin routes
*/
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuth::class, 'login']); // admin login to get token

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/submissions', [AdminSubmission::class, 'index']);
        Route::get('/submissions/{id}', [AdminSubmission::class, 'show']);
        Route::patch('/submissions/{id}/status', [AdminSubmission::class, 'updateStatus']);
    });
});

// Route::prefix('admin')->group(function () {
//     Route::post('/login', [AdminAuth::class, 'login']);
//     Route::post('/logout', [AdminAuth::class, 'logout'])->middleware(['auth:sanctum', 'admin']);
// });
