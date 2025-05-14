<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ZohoAuthController;
use App\Http\Middleware\AuthenticateAdmin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

URL::forceScheme('http');

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

Route::get('/get-contact', [ContactController::class, 'getContact']);
Route::get('/get-services', [ServiceController::class, 'getServices']);
Route::get('/google-reviews', [ReviewsController::class, 'getGoogleReviews']);
Route::get('/facebook-reviews', [ReviewsController::class, 'getFacebookReviews']);
Route::get('/get-slider', [PhotoController::class, 'getPhotoSlider'])->name('photos.getPhotoSlider');
Route::get('/get-photos', [PhotoController::class, 'index'])->name('photos.index');
Route::post('/send-application', [ApplicationController::class, 'sendApplication'])->name('applications.sendApplication');

Route::middleware([AuthenticateAdmin::class])->group(function () {
    Route::post('/services', [ServiceController::class, 'handleServices']);
    Route::post('/save-contact', [ContactController::class, 'saveContact']);
    Route::get('/get-clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/save-clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/show-clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::put('/update-clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/destroy-clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('/get-applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/save-applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/show-applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::put('/update-applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    Route::delete('/destroy-applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');

    Route::post('/save-photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/show-photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
    Route::post('/update-photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/destroy-photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
});

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/check-auth', [AuthController::class, 'checkAuth']);

    // Захищені маршрути
    Route::middleware([AuthenticateAdmin::class])->group(function () {
        Route::post('/', [ContactController::class, 'saveContact']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'getUser']);
    });
});
//
Route::get('/zoho/auth', [ZohoAuthController::class, 'generateAuthUrl']);
Route::get('/zoho/callback', [ZohoAuthController::class, 'callback']);
Route::get('/zoho/test', [ZohoAuthController::class, 'test']);

// routes/web.php
Route::get('/test-mail', function () {
    $data = ['message' => 'Це тестовий email від Laravel з Zoho Mail'];

    Mail::to('fcdnipro268@gmail.com')->send(new \App\Mail\TestMail($data));

    return 'Тестовий лист надіслано!';
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');