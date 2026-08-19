<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\PublicSalonController;
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

Route::post('/salon/{qr_token}/booking', [
    PublicBookingController::class,
    'store',
])->name('salon.booking.store');

Route::get('/salon/{qr_token}/booking', [
    PublicBookingController::class,
    'create',
])->name('salon.booking.create');

Route::get('/salon/{qr_token}/booking/success/{booking}', [
    PublicBookingController::class,
    'success',
])->name('salon.booking.success');
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


                // Create Manual Booking
                Route::get('/create', [
                    BookingController::class,
                    'create'
                ])->name('create');


                // Store Manual Booking
                Route::post('/', [
                    BookingController::class,
                    'store'
                ])->name('store');


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
        /*
        |--------------------------------------------------------------------------
        | Working Hours
        |--------------------------------------------------------------------------
        */

        Route::prefix('working-hours')
            ->name('working-hours.')
            ->group(function () {

                // Weekly schedule
                Route::get('/', [
                    WorkingHourController::class,
                    'index'
                ])->name('index');


                // Save complete weekly schedule
                Route::put('/', [
                    WorkingHourController::class,
                    'updateWeek'
                ])->name('update-week');

            });


        /*
        |--------------------------------------------------------------------------
        | QR
        |--------------------------------------------------------------------------
        */

        /*
  |--------------------------------------------------------------------------
  | QR
  |--------------------------------------------------------------------------
  */

        Route::prefix('qr')
            ->name('qr.')
            ->group(function () {

                /*
                |--------------------------------------------------------------------------
                | QR Page
                |--------------------------------------------------------------------------
                */

                Route::get('/', [
                    QrController::class,
                    'index'
                ])->name('index');


                /*
                |--------------------------------------------------------------------------
                | Generate QR
                |--------------------------------------------------------------------------
                */

                Route::post('/generate', [
                    QrController::class,
                    'generate'
                ])->name('generate');


                /*
                |--------------------------------------------------------------------------
                | QR Image
                |--------------------------------------------------------------------------
                */

                Route::get('/image', [
                    QrController::class,
                    'image'
                ])->name('image');


                /*
                |--------------------------------------------------------------------------
                | Download QR
                |--------------------------------------------------------------------------
                */

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

        Route::prefix('reviews')
            ->name('reviews.')
            ->group(function () {

                // Reviews dashboard
                Route::get('/', [
                    ReviewController::class,
                    'index'
                ])->name('index');


                // Publish review
                Route::patch('/{review}/publish', [
                    ReviewController::class,
                    'publish'
                ])->name('publish');


                // Reject / hide review
                Route::patch('/{review}/reject', [
                    ReviewController::class,
                    'reject'
                ])->name('reject');

            });
        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        Route::prefix('gallery')
            ->name('gallery.')
            ->group(function () {

                Route::get('/', [
                    GalleryController::class,
                    'index'
                ])->name('index');

                Route::get('/create', [
                    GalleryController::class,
                    'create'
                ])->name('create');

                Route::post('/', [
                    GalleryController::class,
                    'store'
                ])->name('store');

                Route::get('/{galleryItem}/edit', [
                    GalleryController::class,
                    'edit'
                ])->name('edit');

                Route::put('/{galleryItem}', [
                    GalleryController::class,
                    'update'
                ])->name('update');

                Route::delete('/{galleryItem}', [
                    GalleryController::class,
                    'destroy'
                ])->name('destroy');

            });
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
