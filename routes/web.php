<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Post\CommentController;
use App\Http\Controllers\User\AccountController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ChangePasswordController;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    
    Route::prefix('login')->name('login')->group(function () {
        Route::get('/', [LoginController::class, 'create']);
        Route::post('/', [LoginController::class, 'store']);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('profile');
        Route::put('/', [AccountController::class, 'update'])->name('update');
        Route::delete('/', [AccountController::class, 'destroy'])->name('delete');
        Route::put('/avatar', [AccountController::class, 'updateAvatar'])->name('avatar.update');
        Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('change.password');
        Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout');
    });

    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
        Route::post('/{post}', [CommentController::class, 'store'])->name('store');
    });

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index')->withoutMiddleware(['auth']);
        Route::get('/{slug}', [PostController::class, 'show'])->name('show')->withoutMiddleware(['auth']);;
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    });
});