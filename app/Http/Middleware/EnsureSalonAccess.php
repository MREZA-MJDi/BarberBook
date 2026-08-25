<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSalonAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | Authenticated User
        |--------------------------------------------------------------------------
        */

        $user = $request->user();

        abort_if(
            !$user,
            401
        );


        /*
        |--------------------------------------------------------------------------
        | User Salon
        |--------------------------------------------------------------------------
        |
        | هر حساب مدیریتی باید یک Salon داشته باشد.
        |
        */

        $salon = $user->salon;


        if (!$salon) {

            abort(
                403,
                'برای این حساب هنوز سالنی ثبت نشده است.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Current Salon Context
        |--------------------------------------------------------------------------
        |
        | Salon فعلی را روی Request قرار می‌دهیم تا در صورت نیاز
        | Controllerها بتوانند از آن استفاده کنند.
        |
        */

        $request->attributes->set(
            'currentSalon',
            $salon
        );


        /*
        |--------------------------------------------------------------------------
        | Continue
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
