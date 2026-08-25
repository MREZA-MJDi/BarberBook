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
use App\Models\Salon;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Guest / Authentication
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
        'create',
    ])->name('login');


    /*
    |--------------------------------------------------------------------------
    | Login Submit
    |--------------------------------------------------------------------------
    */

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
| Super Admin:
|   / → /admin/salons
|
| Barber:
|   / → /dashboard
|
*/

Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    return match ((int) $user->role_id) {

        /*
        | Super Admin
        */
        1 => redirect()->route(
            'admin.salons.index'
        ),

        /*
        | Barber
        */
        2 => redirect()->route(
            'dashboard'
        ),

        /*
        | Unknown Role
        */
        default => abort(403),

    };

})->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC SALON
|--------------------------------------------------------------------------
|
| URL جدید:
|
| /salon/alijenab
| /salon/naser
| /salon/khams
|
| Model Binding:
| {salon:slug}
|
*/

Route::get('/salon/{salon:slug}', [
    PublicSalonController::class,
    'show',
])
    ->where(
        'salon',
        '[a-z0-9]+(?:-[a-z0-9]+)*'
    )
    ->name('salon.public');


/*
|--------------------------------------------------------------------------
| LEGACY QR URL
|--------------------------------------------------------------------------
|
| QRهای قدیمی:
|
| /salon/BB-ROBYWR66R91OPWGM
|
| به URL جدید منتقل می‌شوند:
|
| /salon/alijenab
|
| این Route فقط برای QRهای قدیمی است.
|
*/

Route::get('/salon/{qr_token}', function (
    string $qr_token
) {

    $salon = Salon::query()
        ->where('qr_token', $qr_token)
        ->where('is_active', true)
        ->firstOrFail();

    return redirect()->route(
        'salon.public',
        [
            'salon' => $salon->slug,
        ],
        301
    );

})
    ->where(
        'qr_token',
        'BB-[A-Z0-9]+'
    )
    ->name('salon.legacy');


/*
|--------------------------------------------------------------------------
| PUBLIC BOOKING
|--------------------------------------------------------------------------
|
| URL:
|
| /salon/alijenab/booking
|
*/

Route::get('/salon/{salon:slug}/booking', [
    PublicBookingController::class,
    'create',
])
    ->where(
        'salon',
        '[a-z0-9]+(?:-[a-z0-9]+)*'
    )
    ->name('salon.booking.create');


/*
|--------------------------------------------------------------------------
| PUBLIC BOOKING STORE
|--------------------------------------------------------------------------
*/

Route::post('/salon/{salon:slug}/booking', [
    PublicBookingController::class,
    'store',
])
    ->where(
        'salon',
        '[a-z0-9]+(?:-[a-z0-9]+)*'
    )
    ->name('salon.booking.store');


/*
|--------------------------------------------------------------------------
| PUBLIC BOOKING SUCCESS
|--------------------------------------------------------------------------
|
| Reference Code:
|
| /salon/alijenab/booking/success/BB-XXXXXXXX
|
*/

Route::get(
    '/salon/{salon:slug}/booking/success/{booking}',
    [
        PublicBookingController::class,
        'success',
    ]
)
    ->where(
        'salon',
        '[a-z0-9]+(?:-[a-z0-9]+)*'
    )
    ->where(
        'booking',
        'BB-[A-Za-z0-9]+'
    )
    ->name('salon.booking.success');


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

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            BookingTrackingController::class,
            'create',
        ])->name('form');


        /*
        |--------------------------------------------------------------------------
        | Lookup
        |--------------------------------------------------------------------------
        */

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

    Route::post(
        '/logout',
        LogoutController::class
    )->name('logout');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Super Admin:
    |
    | role_id = 1
    |
    | بدون نیاز به Salon
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

                    /*
                    | Index
                    */

                    Route::get('/', [
                        AdminSalonController::class,
                        'index',
                    ])->name('index');


                    /*
                    | Create
                    */

                    Route::get('/create', [
                        AdminSalonController::class,
                        'create',
                    ])->name('create');


                    /*
                    | Store
                    */

                    Route::post('/', [
                        AdminSalonController::class,
                        'store',
                    ])->name('store');


                    /*
                    | Edit
                    */

                    Route::get('/{salon}/edit', [
                        AdminSalonController::class,
                        'edit',
                    ])->name('edit');


                    /*
                    | Update
                    */

                    Route::put('/{salon}', [
                        AdminSalonController::class,
                        'update',
                    ])->name('update');


                    /*
                    | Delete
                    */

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
    | auth
    | +
    | salon
    |
    | Barber باید Salon داشته باشد.
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

                    /*
                    | QR Dashboard
                    */

                    Route::get('/', [
                        QrController::class,
                        'index',
                    ])->name('index');


                    /*
                    | Generate
                    |
                    | فعلاً برای compatibility نگه داشته شده.
                    | QR token در Create Salon ساخته می‌شود.
                    */

                    Route::post('/generate', [
                        QrController::class,
                        'generate',
                    ])->name('generate');


                    /*
                    | QR Image
                    */

                    Route::get('/image', [
                        QrController::class,
                        'image',
                    ])->name('image');


                    /*
                    | QR Download
                    */

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
    | CUSTOMER ACCOUNT AREA
    |--------------------------------------------------------------------------
    |
    | فعلاً auth می‌خواهد.
    |
    | Public Customer از این بخش استفاده نمی‌کند.
    |
    */


});
