<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */

    ->withMiddleware(function (Middleware $middleware): void {

        //
        // Middleware های فعلی پروژه اینجا قرار می‌گیرند.
        // فعلاً چیزی تغییر نمی‌دهیم.
        //

    })

    /*
    |--------------------------------------------------------------------------
    | Global Exception Handling
    |--------------------------------------------------------------------------
    */

    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |--------------------------------------------------------------------------
        | Validation Errors
        |--------------------------------------------------------------------------
        |
        | Laravel به صورت پیش‌فرض ValidationException را مدیریت می‌کند.
        | اینجا فقط مطمئن می‌شویم که رفتار آن برای فرم‌های وب حفظ شود.
        |
        */

        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'اطلاعات وارد شده صحیح نیست.',
                    'errors' => $e->errors(),
                ], 422);

            }

            return back()
                ->withInput()
                ->withErrors($e->errors());

        });


        /*
        |--------------------------------------------------------------------------
        | HTTP Exceptions
        |--------------------------------------------------------------------------
        |
        | 403 / 404 / 419 / 429 / 500 و ...
        |
        */

        $exceptions->render(function (
            HttpExceptionInterface $e,
            Request $request
        ) {

            $status = $e->getStatusCode();


            /*
            |--------------------------------------------------------------------------
            | API / AJAX / JSON
            |--------------------------------------------------------------------------
            */

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => match ($status) {

                        401 => 'برای ادامه باید وارد حساب کاربری شوید.',

                        403 => 'شما اجازه انجام این عملیات را ندارید.',

                        404 => 'مورد مورد نظر پیدا نشد.',

                        419 => 'نشست شما منقضی شده است. لطفاً دوباره تلاش کنید.',

                        429 => 'تعداد درخواست‌ها بیش از حد مجاز است. کمی بعد دوباره تلاش کنید.',

                        default => 'درخواست قابل پردازش نیست.',

                    },
                ], $status);

            }


            /*
            |--------------------------------------------------------------------------
            | Web Pages
            |--------------------------------------------------------------------------
            */

            return match ($status) {

                401 => redirect()
                    ->route('login')
                    ->with('error', 'برای ادامه باید وارد حساب کاربری شوید.'),


                403 => response()
                    ->view('errors.403', [], 403),


                404 => response()
                    ->view('errors.404', [], 404),


                419 => back()
                    ->withInput()
                    ->with('error', 'نشست شما منقضی شده است. لطفاً دوباره تلاش کنید.'),


                429 => response()
                    ->view('errors.429', [], 429),


                default => null,

            };

        });


        /*
        |--------------------------------------------------------------------------
        | Unexpected Exceptions
        |--------------------------------------------------------------------------
        |
        | خطاهای پیش‌بینی‌نشده:
        | Database
        | Logic
        | Runtime
        | TypeError
        | ...
        |
        */

        $exceptions->render(function (
            Throwable $e,
            Request $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | JSON Response
            |--------------------------------------------------------------------------
            */

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => app()->isProduction()
                        ? 'خطایی در پردازش درخواست رخ داد.'
                        : $e->getMessage(),
                ], 500);

            }


            /*
            |--------------------------------------------------------------------------
            | Production
            |--------------------------------------------------------------------------
            */

            if (app()->isProduction()) {

                return response()
                    ->view('errors.500', [], 500);

            }


            /*
            |--------------------------------------------------------------------------
            | Development
            |--------------------------------------------------------------------------
            |
            | در محیط local اجازه می‌دهیم Laravel صفحه Debug خودش
            | را نمایش دهد تا خطا را راحت پیدا کنیم.
            |
            */

            return null;

        });


        /*
        |--------------------------------------------------------------------------
        | Logging
        |--------------------------------------------------------------------------
        |
        | همه Exception ها در Laravel Log ثبت می‌شوند.
        |
        */

        $exceptions->report(function (Throwable $e): void {

            //
            // Laravel به صورت پیش‌فرض Exception را Log می‌کند.
            // این callback را عمداً خالی نگه می‌داریم تا
            // Logging دوباره انجام نشود.
            //

        });

    })

    ->create();
