<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\SalonController as AdminSalonController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingTrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\PublicSalonController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkingHourController;

// Future Customer Controllers
use App\Http\Controllers\Customer\CustomerBookingController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerNotificationController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerSettingsController;

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
| Home
|--------------------------------------------------------------------------
|
| Guest:
|   / → /login
|
| Authenticated:
|   / → /dashboard
|
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

})->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC SALON
|--------------------------------------------------------------------------
|
| بدون Login
|
*/

Route::get('/salon/{qr_token}', [
    PublicSalonController::class,
    'show',
])->name('salon.public');


/*
|--------------------------------------------------------------------------
| PUBLIC BOOKING
|--------------------------------------------------------------------------
|
| بدون Login
|
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
| PUBLIC BOOKING TRACKING
|--------------------------------------------------------------------------
|
| بدون Login
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
| AUTHENTICATED
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
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Super Admin:
    | auth + superadmin
    |
    | این بخش روی Salon خاصی scope نمی‌شود،
    | چون قرار است تمام سالن‌ها را مدیریت کند.
    |
    */

    Route::middleware('superadmin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Salon Management
            |--------------------------------------------------------------------------
            */

            Route::prefix('salons')
                ->name('salons.')
                ->group(function () {

                    Route::get('/', [
                        AdminSalonController::class,
                        'index',
                    ])->name('index');


                    Route::get('/create', [
                        AdminSalonController::class,
                        'create',
                    ])->name('create');


                    Route::post('/', [
                        AdminSalonController::class,
                        'store',
                    ])->name('store');


                    Route::get('/{salon}/edit', [
                        AdminSalonController::class,
                        'edit',
                    ])->name('edit');


                    Route::put('/{salon}', [
                        AdminSalonController::class,
                        'update',
                    ])->name('update');


                    Route::delete('/{salon}', [
                        AdminSalonController::class,
                        'destroy',
                    ])->name('destroy');

                });

        });


    /*
    |--------------------------------------------------------------------------
    | BARBER / SALON AREA
    |--------------------------------------------------------------------------
    |
    | auth + salon
    |
    | هر آرایشگر فقط Salon خودش را می‌بیند.
    |
    */

    Route::middleware('salon')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Dashboard Prefix
        |--------------------------------------------------------------------------
        */

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
            | BOOKINGS
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
            | SALON
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
            | SERVICES
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
            | WORKING HOURS
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
            | QR
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
            | REVIEWS
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
            | GALLERY
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
            | SETTINGS
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
            | PROFILE
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

    });


    /*
    |--------------------------------------------------------------------------
    | FUTURE CUSTOMER ACCOUNT AREA
    |--------------------------------------------------------------------------
    |
    | فعلاً این بخش Login می‌خواهد.
    | Customer عمومی QR از این بخش استفاده نمی‌کند.
    |
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
            | Bookings
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
            | Reviews
            |--------------------------------------------------------------------------
            */

            Route::get('/reviews', [
                CustomerReviewController::class,
                'index',
            ])->name('reviews.index');


            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */

            Route::get('/notifications', [
                CustomerNotificationController::class,
                'index',
            ])->name('notifications.index');


            /*
            |--------------------------------------------------------------------------
            | Settings
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
