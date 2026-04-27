<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('main.index');

// Auth routes
Route::get('/admin/login',  [AuthController::class, 'showLogin'])->name('auth.login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login'])->name('auth.login.post')->middleware('guest');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // User management
    Route::resource('users', UserManagementController::class)->except(['show'])->names([
        'index'   => 'users.index',
        'create'  => 'users.create',
        'store'   => 'users.store',
        'edit'    => 'users.edit',
        'update'  => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    Route::get('users/{user}',                           [UserManagementController::class, 'show'])->name('users.show');
    Route::post('users/{user}/impersonate',              [UserManagementController::class, 'impersonate'])->name('users.impersonate');
    Route::post('users/stop-impersonating',              [UserManagementController::class, 'stopImpersonating'])->name('users.stop-impersonating');

    // Google OAuth
    Route::get('/google/redirect',      [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/google/callback',      [GoogleController::class, 'callback'])->name('google.callback');
    Route::delete('/google/disconnect', [GoogleController::class, 'disconnect'])->name('google.disconnect');

    // Reviews
    Route::get('/reviews',       [ReviewsController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/sync', [ReviewsController::class, 'sync'])->name('reviews.sync');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/platforms',    [AdminController::class, 'platforms'])->name('platforms');
        Route::get('/templates',    [AdminController::class, 'templates'])->name('templates');
        Route::get('/integrations', [AdminController::class, 'integrations'])->name('integrations');
        Route::get('/automation',   [AdminController::class, 'automation'])->name('automation');
        Route::get('/appearance',   [AdminController::class, 'appearance'])->name('appearance');
    });
});
