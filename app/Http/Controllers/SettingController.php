<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $salon = $user->salon;

        return view('dashboard.settings.index', [
            'user' => $user,
            'salon' => $salon,
        ]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $salon = $user->salon;

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'instagram' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'name.required' => 'نام سالن الزامی است.',
            'name.string' => 'نام سالن معتبر نیست.',
            'name.max' => 'نام سالن نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'description.string' => 'توضیحات سالن معتبر نیست.',
            'description.max' => 'توضیحات سالن نمی‌تواند بیشتر از ۲۰۰۰ کاراکتر باشد.',

            'phone.string' => 'شماره تماس معتبر نیست.',
            'phone.max' => 'شماره تماس نمی‌تواند بیشتر از ۳۰ کاراکتر باشد.',

            'address.string' => 'آدرس سالن معتبر نیست.',
            'address.max' => 'آدرس سالن نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.',

            'instagram.string' => 'اطلاعات اینستاگرام معتبر نیست.',
            'instagram.max' => 'اطلاعات اینستاگرام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);


        $salon->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
        ]);


        return redirect()
            ->route('settings.index')
            ->with(
                'success',
                'اطلاعات سالن با موفقیت بروزرسانی شد.'
            );
    }
}
