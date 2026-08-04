<?php

use Illuminate\Support\Facades\Route;


// Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkingHourController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;



/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {


    // Login
    Route::get('/login',
        [LoginController::class, 'create']
    )->name('login');


    Route::post('/login',
        [LoginController::class, 'store']
    )->name('login.store');


});





/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {



    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout',
        LogoutController::class
    )->name('logout');





    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class,'index']
    )->name('dashboard');





    /*
    |--------------------------------------------------------------------------
    | Bookings
    |--------------------------------------------------------------------------
    */

    Route::prefix('bookings')
        ->name('bookings.')
        ->group(function(){


            Route::get('/',
                [BookingController::class,'index']
            )->name('index');



            Route::get('/{booking}',
                [BookingController::class,'show']
            )->name('show');



            Route::put('/{booking}',
                [BookingController::class,'update']
            )->name('update');


        });






    /*
    |--------------------------------------------------------------------------
    | Salon
    |--------------------------------------------------------------------------
    */

    Route::prefix('salon')
        ->name('salon.')
        ->group(function(){


            Route::get('/',
                [SalonController::class,'index']
            )->name('index');



            Route::get('/edit',
                [SalonController::class,'edit']
            )->name('edit');



            Route::put('/update',
                [SalonController::class,'update']
            )->name('update');


        });






    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'services',
        ServiceController::class
    );







    /*
    |--------------------------------------------------------------------------
    | Working Hours
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'working-hours',
        WorkingHourController::class
    );







    /*
    |--------------------------------------------------------------------------
    | QR
    |--------------------------------------------------------------------------
    */

    Route::prefix('qr')
        ->name('qr.')
        ->group(function(){


            Route::get('/',
                [QrController::class,'index']
            )->name('index');



            Route::get('/download',
                [QrController::class,'download']
            )->name('download');


        });








    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'reviews',
        ReviewController::class
    )->only([
        'index',
        'show'
    ]);







    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::get('/settings',
        [SettingController::class,'index']
    )->name('settings.index');



    Route::put('/settings',
        [SettingController::class,'update']
    )->name('settings.update');








    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',
        [ProfileController::class,'edit']
    )->name('profile.edit');



    Route::put('/profile',
        [ProfileController::class,'update']
    )->name('profile.update');



});
