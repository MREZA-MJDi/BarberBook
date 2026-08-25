<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(
        LoginRequest $request
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Authenticate
        |--------------------------------------------------------------------------
        */

        $request->authenticate();


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Current User
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();


        /*
        |--------------------------------------------------------------------------
        | Redirect By Role
        |--------------------------------------------------------------------------
        |
        | 1 = Super Admin
        | 2 = Barber
        |
        */

        return match ((int) $user->role_id) {

            /*
            |--------------------------------------------------------------------------
            | Super Admin
            |--------------------------------------------------------------------------
            */

            1 => redirect()
                ->route('admin.salons.index')
                ->with(
                    'success',
                    'خوش آمدید.'
                ),


            /*
            |--------------------------------------------------------------------------
            | Barber
            |--------------------------------------------------------------------------
            */

            2 => redirect()
                ->route('dashboard'),


            /*
            |--------------------------------------------------------------------------
            | Unknown Role
            |--------------------------------------------------------------------------
            */

            default => abort(403),

        };
    }
}
