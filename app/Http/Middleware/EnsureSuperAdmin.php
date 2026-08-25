<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
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
        | Authentication
        |--------------------------------------------------------------------------
        |
        | این Middleware برای کاربران لاگین‌شده است.
        | اگر کاربر وجود نداشته باشد، اجازه ادامه نمی‌دهیم.
        |
        */

        if (!$request->user()) {

            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | Super Admin Check
        |--------------------------------------------------------------------------
        |
        | در ساختار فعلی پروژه:
        |
        | role_id = 1 → Super Admin
        | role_id = 2 → Barber
        |
        */

        if ((int) $request->user()->role_id !== 1) {

            abort(
                403,
                'شما اجازه دسترسی به پنل مدیریت سیستم را ندارید.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Continue
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
