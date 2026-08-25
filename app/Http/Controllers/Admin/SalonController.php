<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSalonRequest;
use App\Http\Requests\Admin\UpdateSalonRequest;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SalonController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display all salons.
     */
    public function index(Request $request): View
    {
        $query = Salon::query()
            ->with('user')
            ->latest('id');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($query) use ($search) {

                $query
                    ->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'slug',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'full_name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'phone',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $salons = $query
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.salons.index',
            compact('salons')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    /**
     * Show create salon form.
     */
    public function create(): View
    {
        return view(
            'admin.salons.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Create barber account, salon and QR token.
     *
     * User + Salon are created atomically.
     */
    public function store(
        StoreSalonRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Create User + Salon + QR
        |--------------------------------------------------------------------------
        */

        $salon = DB::transaction(
            function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | Barber User
                |--------------------------------------------------------------------------
                |
                | Current project roles:
                |
                | 1 = Super Admin
                | 2 = Barber
                |
                */

                $user = User::create([

                    'role_id' => 2,

                    'full_name' =>
                        $validated['full_name'],

                    'phone' =>
                        $validated['user_phone'],

                    'email' =>
                        $validated['email'],

                    'password' =>
                        Hash::make(
                            $validated['password']
                        ),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Salon
                |--------------------------------------------------------------------------
                */

                return Salon::create([

                    'user_id' =>
                        $user->id,

                    'name' =>
                        $validated['name'],

                    'slug' =>
                        $this->generateUniqueSlug(
                            $validated['name']
                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | QR Token
                    |--------------------------------------------------------------------------
                    |
                    | QR توسط Super Admin همان لحظه ایجاد می‌شود.
                    |
                    */

                    'qr_token' =>
                        $this->generateUniqueQrToken(),

                    'phone' =>
                        $validated['phone'] ?? null,

                    'address' =>
                        $validated['address'] ?? null,

                    'instagram' =>
                        $validated['instagram'] ?? null,

                    'description' =>
                        $validated['description'] ?? null,

                    'is_active' =>
                        true,

                ]);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.salons.index')
            ->with(
                'success',
                "سالن «{$salon->name}»، حساب آرایشگر و QR Code با موفقیت ساخته شدند."
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    /**
     * Show salon edit form.
     */
    public function edit(
        Salon $salon
    ): View {
        $salon->load('user');

        return view(
            'admin.salons.edit',
            compact('salon')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    /**
     * Update salon and barber account.
     */
    public function update(
        UpdateSalonRequest $request,
        Salon $salon
    ): RedirectResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        $user = $salon->user;

        abort_if(
            !$user,
            404,
            'مالک این سالن پیدا نشد.'
        );


        /*
        |--------------------------------------------------------------------------
        | Update User + Salon
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $validated,
                $request,
                $salon,
                $user
            ) {

                /*
                |--------------------------------------------------------------------------
                | User Data
                |--------------------------------------------------------------------------
                */

                $userData = [

                    'full_name' =>
                        $validated['full_name'],

                    'phone' =>
                        $validated['user_phone'],

                    'email' =>
                        $validated['email'],

                ];


                /*
                |--------------------------------------------------------------------------
                | Optional Password
                |--------------------------------------------------------------------------
                */

                if (
                    filled(
                        $validated['password'] ?? null
                    )
                ) {

                    $userData['password'] =
                        Hash::make(
                            $validated['password']
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Update User
                |--------------------------------------------------------------------------
                */

                $user->update(
                    $userData
                );


                /*
                |--------------------------------------------------------------------------
                | Update Salon
                |--------------------------------------------------------------------------
                |
                | QR Token intentionally remains unchanged.
                |
                */

                $salon->update([

                    'name' =>
                        $validated['name'],

                    'phone' =>
                        $validated['phone'] ?? null,

                    'address' =>
                        $validated['address'] ?? null,

                    'instagram' =>
                        $validated['instagram'] ?? null,

                    'description' =>
                        $validated['description'] ?? null,

                    'is_active' =>
                        $request->boolean(
                            'is_active'
                        ),

                ]);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.salons.index'
            )
            ->with(
                'success',
                'اطلاعات سالن و حساب آرایشگر با موفقیت بروزرسانی شد.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    /**
     * Delete salon and barber account.
     *
     * IMPORTANT:
     * Related records must have appropriate foreign-key behavior.
     */
    public function destroy(
        Salon $salon
    ): RedirectResponse {
        $user = $salon->user;

        DB::transaction(
            function () use (
                $salon,
                $user
            ) {

                /*
                |--------------------------------------------------------------------------
                | Delete Salon
                |--------------------------------------------------------------------------
                */

                $salon->delete();


                /*
                |--------------------------------------------------------------------------
                | Delete User
                |--------------------------------------------------------------------------
                */

                if ($user) {
                    $user->delete();
                }

            }
        );


        return redirect()
            ->route(
                'admin.salons.index'
            )
            ->with(
                'success',
                'سالن و حساب آرایشگر با موفقیت حذف شدند.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique Slug
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a unique salon slug.
     */
    private function generateUniqueSlug(
        string $name
    ): string {
        $baseSlug = Str::slug(
            $name
        );


        /*
        |--------------------------------------------------------------------------
        | Persian / Empty Slug Fallback
        |--------------------------------------------------------------------------
        */

        if ($baseSlug === '') {

            $baseSlug =
                'salon-' .
                Str::lower(
                    Str::random(8)
                );

        }


        $slug = $baseSlug;

        $counter = 1;


        /*
        |--------------------------------------------------------------------------
        | Ensure Unique Slug
        |--------------------------------------------------------------------------
        */

        while (
        Salon::query()
            ->where(
                'slug',
                $slug
            )
            ->exists()
        ) {

            $slug =
                $baseSlug .
                '-' .
                $counter;

            $counter++;

        }


        return $slug;
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique QR Token
    |--------------------------------------------------------------------------
    */

    /**
     * Generate a unique QR token.
     */
    private function generateUniqueQrToken(): string
    {
        do {

            $token =
                'BB-' .
                strtoupper(
                    Str::random(16)
                );

        } while (
            Salon::query()
                ->where(
                    'qr_token',
                    $token
                )
                ->exists()
        );


        return $token;
    }
}
