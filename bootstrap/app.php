<?php

use App\Http\Middleware\EnsureSalonAccess;
use App\Http\Middleware\EnsureSuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(
    basePath: dirname(__DIR__)
)

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

        /*
        |--------------------------------------------------------------------------
        | Guest Redirect
        |--------------------------------------------------------------------------
        |
        | کاربر مهمان وقتی وارد Route محافظت‌شده شود،
        | مستقیماً به /login هدایت می‌شود.
        |
        */

        $middleware->redirectGuestsTo('/login');


        /*
        |--------------------------------------------------------------------------
        | Middleware Aliases
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'salon' => EnsureSalonAccess::class,
            'superadmin' => EnsureSuperAdmin::class,

        ]);

    })

    /*
    |--------------------------------------------------------------------------
    | Exception Handling
    |--------------------------------------------------------------------------
    */

    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |--------------------------------------------------------------------------
        | Validation Exceptions
        |--------------------------------------------------------------------------
        */

        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'اطلاعات وارد شده صحیح نیست.',
                    'errors' => $e->errors(),
                ], 422);

            }


            /*
            |--------------------------------------------------------------------------
            | Web
            |--------------------------------------------------------------------------
            */

            return back()
                ->withInput()
                ->withErrors($e->errors());

        });


        /*
        |--------------------------------------------------------------------------
        | HTTP Exceptions
        |--------------------------------------------------------------------------
        */

        $exceptions->render(function (
            HttpExceptionInterface $e,
            Request $request
        ) {

            $status = $e->getStatusCode();


            /*
            |--------------------------------------------------------------------------
            | JSON / API
            |--------------------------------------------------------------------------
            */

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => match ($status) {

                        401 =>
                        'برای ادامه باید وارد حساب کاربری شوید.',

                        403 =>
                        'شما اجازه انجام این عملیات را ندارید.',

                        404 =>
                        'مورد مورد نظر پیدا نشد.',

                        419 =>
                        'نشست شما منقضی شده است. لطفاً دوباره تلاش کنید.',

                        429 =>
                        'تعداد درخواست‌ها بیش از حد مجاز است. کمی بعد دوباره تلاش کنید.',

                        default =>
                        'درخواست قابل پردازش نیست.',
                    },
                ], $status);

            }


            /*
            |--------------------------------------------------------------------------
            | Web
            |--------------------------------------------------------------------------
            */

            return match ($status) {

                401 => redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'برای ادامه باید وارد حساب کاربری شوید.'
                    ),

                403 => response()
                    ->view('errors.403', [], 403),

                404 => response()
                    ->view('errors.404', [], 404),

                419 => back()
                    ->withInput()
                    ->with(
                        'error',
                        'نشست شما منقضی شده است. لطفاً دوباره تلاش کنید.'
                    ),

                429 => response()
                    ->view('errors.429', [], 429),

                default => null,
            };

        });


        /*
        |--------------------------------------------------------------------------
        | Unexpected Exceptions
        |--------------------------------------------------------------------------
        */

        $exceptions->render(function (
            Throwable $e,
            Request $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | JSON
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
            | Local Development
            |--------------------------------------------------------------------------
            */

            return null;

        });


        /*
        |--------------------------------------------------------------------------
        | Exception Reporting
        |--------------------------------------------------------------------------
        */

        $exceptions->report(function (Throwable $e): void {

            /*
            |--------------------------------------------------------------------------
            | Laravel default logging
            |--------------------------------------------------------------------------
            |
            | عمداً کاری انجام نمی‌دهیم تا Exception دوبار
            | Log نشود.
            |
            */

        });

    })

    ->create();
