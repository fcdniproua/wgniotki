<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

URL::forceScheme('http');
//URL::forceRootUrl('http://localhost:8080');

Route::get('/', function () {
    return view('welcome');  // Буде використовувати Vue всередині Blade
})->name('home');

// API для Vue (якщо потрібно)
Route::prefix('api')->group(function () {
    Route::get('data', 'ApiController@getData');
});