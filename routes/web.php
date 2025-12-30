<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortenUrlController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // AJAX endpoint for DataTables to fetch users (no blade loops)
    Route::get('/users/data', [DashboardController::class, 'usersData'])->name('users.data');
    // Get single user
    Route::get('/users/{id}', [DashboardController::class, 'getUser'])->name('users.get');
    // Update user via AJAX
    Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/{shortCode}', [ShortenUrlController::class, 'redirectToOriginal'])->name('shortened.redirect');

require __DIR__.'/auth.php';
