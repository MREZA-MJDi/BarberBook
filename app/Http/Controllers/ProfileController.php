<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update(
            $request->validated()
        );

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'اطلاعات پروفایل با موفقیت بروزرسانی شد.'
            );
    }
}
