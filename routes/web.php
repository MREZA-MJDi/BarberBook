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

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [
        LoginController::class,
        'create'
    ])->name('login');


    Route::post('/login', [
        LoginController::class,
        'store'
    ])->name('login.store');

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', LogoutController::class)
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Dashboard Modules
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Salon Daily Status
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/salon/close-today',
            [
                DashboardController::class,
                'closeToday'
            ]
        )->name('dashboard.salon.close-today');


        Route::patch(
            '/salon/open-today',
            [
                DashboardController::class,
                'openToday'
            ]
        )->name('dashboard.salon.open-today');


        /*
        |--------------------------------------------------------------------------
        | Bookings
        |--------------------------------------------------------------------------
        */

        Route::prefix('bookings')
            ->name('bookings.')
            ->group(function () {

                // List
                Route::get('/', [
                    BookingController::class,
                    'index'
                ])->name('index');


                // Show
                Route::get('/{booking}', [
                    BookingController::class,
                    'show'
                ])->name('show');


                // Approve
                Route::patch('/{booking}/approve', [
                    BookingController::class,
                    'approve'
                ])->name('approve');


                // Reject
                Route::patch('/{booking}/reject', [
                    BookingController::class,
                    'reject'
                ])->name('reject');


                // Complete
                Route::patch('/{booking}/complete', [
                    BookingController::class,
                    'complete'
                ])->name('complete');


                // Reschedule
                Route::patch('/{booking}/reschedule', [
                    BookingController::class,
                    'reschedule'
                ])->name('reschedule');

            });


        /*
        |--------------------------------------------------------------------------
        | Salon
        |--------------------------------------------------------------------------
        */

        Route::prefix('salon')
            ->name('salon.')
            ->group(function () {

                // Salon dashboard / overview
                Route::get('/', [
                    SalonController::class,
                    'index'
                ])->name('index');


                // Edit salon
                Route::get('/edit', [
                    SalonController::class,
                    'edit'
                ])->name('edit');


                // Update salon
                Route::put('/update', [
                    SalonController::class,
                    'update'
                ])->name('update');

            });


        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'services',
            ServiceController::class
        )->except([
            'show'
        ]);


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
            ->group(function () {

                // QR page
                Route::get('/', [
                    QrController::class,
                    'index'
                ])->name('index');


                // Download QR
                Route::get('/download', [
                    QrController::class,
                    'download'
                ])->name('download');

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

        Route::get('/settings', [
            SettingController::class,
            'index'
        ])->name('settings.index');


        Route::put('/settings', [
            SettingController::class,
            'update'
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [
            ProfileController::class,
            'edit'
        ])->name('profile.edit');


        Route::put('/profile', [
            ProfileController::class,
            'update'
        ])->name('profile.update');

    });

});
