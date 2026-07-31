<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkingHourController;

Route::get('/', function () {
    return view('home');
});
Route::get('/salon', function () {

    return view('components.salon.show');

});

Route::get('/salons/{salon:slug}', [SalonController::class, 'show'])
    ->name('salons.show');
