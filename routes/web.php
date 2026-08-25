<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkingHourController;

use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\PublicSalonController;

// Future Customer Controllers
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerNotificationController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerSettingsController;
use App\Http\Controllers\BookingTrackingController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Guest / Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [
        LoginController::class,
        'create',
    ])->name('login');

    Route::post('/login', [
        LoginController::class,
        'store',
    ])->name('login.store');

});


/*
|--------------------------------------------------------------------------
| Landing
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.index');
})->name('home');


/*
|--------------------------------------------------------------------------
| Public Salon
|--------------------------------------------------------------------------
*/

Route::get('/salon/{qr_token}', [
    PublicSalonController::class,
    'show',
])->name('salon.public');


/*
|--------------------------------------------------------------------------
| Public Booking
|--------------------------------------------------------------------------
*/

Route::get('/salon/{qr_token}/booking', [
    PublicBookingController::class,
    'create',
])->name('salon.booking.create');

Route::post('/salon/{qr_token}/booking', [
    PublicBookingController::class,
    'store',
])->name('salon.booking.store');

Route::get('/salon/{qr_token}/booking/success/{booking}', [
    PublicBookingController::class,
    'success',
])->name('salon.booking.success');


/*
|--------------------------------------------------------------------------
| Guest Booking Tracking
|--------------------------------------------------------------------------
|
| No login required.
|
*/

Route::prefix('track-booking')
    ->name('booking.track.')
    ->group(function () {

        Route::get('/', [
            BookingTrackingController::class,
            'create',
        ])->name('form');

        Route::post('/', [
            BookingTrackingController::class,
            'lookup',
        ])->name('lookup');

    });


/*
|--------------------------------------------------------------------------
| Authenticated
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
    | ADMIN / SALON DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index',
    ])->name('dashboard');


    Route::prefix('dashboard')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Salon Daily Status
        |--------------------------------------------------------------------------
        */

        Route::patch('/salon/close-today', [
            DashboardController::class,
            'closeToday',
        ])->name('dashboard.salon.close-today');

        Route::patch('/salon/open-today', [
            DashboardController::class,
            'openToday',
        ])->name('dashboard.salon.open-today');


        /*
        |--------------------------------------------------------------------------
        | Admin Bookings
        |--------------------------------------------------------------------------
        */

        Route::prefix('bookings')
            ->name('bookings.')
            ->group(function () {

                Route::get('/', [
                    BookingController::class,
                    'index',
                ])->name('index');

                Route::get('/create', [
                    BookingController::class,
                    'create',
                ])->name('create');

                Route::post('/', [
                    BookingController::class,
                    'store',
                ])->name('store');

                Route::get('/{booking}', [
                    BookingController::class,
                    'show',
                ])->name('show');

                Route::patch('/{booking}/approve', [
                    BookingController::class,
                    'approve',
                ])->name('approve');

                Route::patch('/{booking}/reject', [
                    BookingController::class,
                    'reject',
                ])->name('reject');

                Route::patch('/{booking}/complete', [
                    BookingController::class,
                    'complete',
                ])->name('complete');

                Route::patch('/{booking}/reschedule', [
                    BookingController::class,
                    'reschedule',
                ])->name('reschedule');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin Salon
        |--------------------------------------------------------------------------
        */

        Route::prefix('salon')
            ->name('salon.')
            ->group(function () {

                Route::get('/', [
                    SalonController::class,
                    'index',
                ])->name('index');

                Route::get('/edit', [
                    SalonController::class,
                    'edit',
                ])->name('edit');

                Route::put('/update', [
                    SalonController::class,
                    'update',
                ])->name('update');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin Services
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'services',
            ServiceController::class
        )->except([
            'show',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin Working Hours
        |--------------------------------------------------------------------------
        */

        Route::prefix('working-hours')
            ->name('working-hours.')
            ->group(function () {

                Route::get('/', [
                    WorkingHourController::class,
                    'index',
                ])->name('index');

                Route::put('/', [
                    WorkingHourController::class,
                    'updateWeek',
                ])->name('update-week');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin QR
        |--------------------------------------------------------------------------
        */

        Route::prefix('qr')
            ->name('qr.')
            ->group(function () {

                Route::get('/', [
                    QrController::class,
                    'index',
                ])->name('index');

                Route::post('/generate', [
                    QrController::class,
                    'generate',
                ])->name('generate');

                Route::get('/image', [
                    QrController::class,
                    'image',
                ])->name('image');

                Route::get('/download', [
                    QrController::class,
                    'download',
                ])->name('download');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin Reviews
        |--------------------------------------------------------------------------
        */

        Route::prefix('reviews')
            ->name('reviews.')
            ->group(function () {

                Route::get('/', [
                    ReviewController::class,
                    'index',
                ])->name('index');

                Route::patch('/{review}/publish', [
                    ReviewController::class,
                    'publish',
                ])->name('publish');

                Route::patch('/{review}/reject', [
                    ReviewController::class,
                    'reject',
                ])->name('reject');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin Gallery
        |--------------------------------------------------------------------------
        */

        Route::prefix('gallery')
            ->name('gallery.')
            ->group(function () {

                Route::get('/', [
                    GalleryController::class,
                    'index',
                ])->name('index');

                Route::get('/create', [
                    GalleryController::class,
                    'create',
                ])->name('create');

                Route::post('/', [
                    GalleryController::class,
                    'store',
                ])->name('store');

                Route::get('/{galleryItem}/edit', [
                    GalleryController::class,
                    'edit',
                ])->name('edit');

                Route::put('/{galleryItem}', [
                    GalleryController::class,
                    'update',
                ])->name('update');

                Route::delete('/{galleryItem}', [
                    GalleryController::class,
                    'destroy',
                ])->name('destroy');

            });


        /*
        |--------------------------------------------------------------------------
        | Admin Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            SettingController::class,
            'index',
        ])->name('settings.index');

        Route::put('/settings', [
            SettingController::class,
            'update',
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Admin Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [
            ProfileController::class,
            'edit',
        ])->name('profile.edit');

        Route::put('/profile', [
            ProfileController::class,
            'update',
        ])->name('profile.update');

    });


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER AREA
    |--------------------------------------------------------------------------
    */

    Route::prefix('customer')
        ->name('customer.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/', [
                CustomerDashboardController::class,
                'index',
            ])->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Customer Bookings
            |--------------------------------------------------------------------------
            */

            Route::prefix('bookings')
                ->name('bookings.')
                ->group(function () {

                    Route::get('/', [
                        CustomerBookingController::class,
                        'index',
                    ])->name('index');

                    Route::get('/{booking}', [
                        CustomerBookingController::class,
                        'show',
                    ])->name('show');

                });


            /*
            |--------------------------------------------------------------------------
            | Customer Reviews
            |--------------------------------------------------------------------------
            */

            Route::get('/reviews', [
                CustomerReviewController::class,
                'index',
            ])->name('reviews.index');


            /*
            |--------------------------------------------------------------------------
            | Customer Notifications
            |--------------------------------------------------------------------------
            */

            Route::get('/notifications', [
                CustomerNotificationController::class,
                'index',
            ])->name('notifications.index');


            /*
            |--------------------------------------------------------------------------
            | Customer Settings
            |--------------------------------------------------------------------------
            */

            Route::get('/settings', [
                CustomerSettingsController::class,
                'index',
            ])->name('settings.index');

            Route::put('/settings', [
                CustomerSettingsController::class,
                'update',
            ])->name('settings.update');

        });

});
