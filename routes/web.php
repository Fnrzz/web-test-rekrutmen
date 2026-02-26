<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoCategoryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome']);
Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/video/{video:slug}', [HomeController::class, 'videoDetail'])->name('video.detail');
Route::post('/video/{video}/request-access', [HomeController::class, 'requestAccess'])->middleware('auth')->name('video.request-access');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/my-videos/pending', [HomeController::class, 'myPendingVideos'])->name('my-videos.pending');
    Route::get('/my-videos/approved', [HomeController::class, 'myApprovedVideos'])->name('my-videos.approved');

    Route::middleware('admin')->prefix('dashboard')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('video-categories', VideoCategoryController::class)->except(['show']);
        Route::resource('videos', VideoController::class)->except(['show']);
        Route::get('video-requests', [VideoRequestController::class, 'index'])->name('video-requests.index');
        Route::post('video-requests/{videoRequest}/approve', [VideoRequestController::class, 'approve'])->name('video-requests.approve');
        Route::post('video-requests/{videoRequest}/reject', [VideoRequestController::class, 'reject'])->name('video-requests.reject');
    });
});
