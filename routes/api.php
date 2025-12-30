<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShortenUrlController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/redirect/{shortCode}', [ShortenUrlController::class, 'redirect']);

Route::middleware('api.auth')->group(function () {
    Route::post('/shorten-url', [ShortenUrlController::class, 'shortenUrl']);
    Route::get('/urls', [ShortenUrlController::class, 'getUrls']);
});
