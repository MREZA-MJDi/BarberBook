<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Barber
            |--------------------------------------------------------------------------
            */

            'full_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'user_phone' => [
                'required',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
            ],


            /*
            |--------------------------------------------------------------------------
            | Salon
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
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

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],


            /*
            |--------------------------------------------------------------------------
            | Branding
            |--------------------------------------------------------------------------
            */

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'cover' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'full_name.required' =>
                'نام و نام خانوادگی آرایشگر را وارد کنید.',

            'email.required' =>
                'ایمیل را وارد کنید.',

            'email.email' =>
                'ایمیل واردشده معتبر نیست.',

            'email.unique' =>
                'این ایمیل قبلاً استفاده شده است.',

            'user_phone.required' =>
                'شماره موبایل آرایشگر را وارد کنید.',

            'password.required' =>
                'رمز عبور را وارد کنید.',

            'password.min' =>
                'رمز عبور باید حداقل ۸ کاراکتر باشد.',

            'password.confirmed' =>
                'تکرار رمز عبور صحیح نیست.',

            'name.required' =>
                'نام سالن را وارد کنید.',

            'logo.image' =>
                'فایل لوگو باید تصویر باشد.',

            'logo.mimes' =>
                'فرمت لوگو باید JPG، PNG یا WEBP باشد.',

            'logo.max' =>
                'حجم لوگو نمی‌تواند بیشتر از ۲ مگابایت باشد.',

            'cover.image' =>
                'فایل تصویر هیرو باید تصویر باشد.',

            'cover.mimes' =>
                'فرمت تصویر هیرو باید JPG، PNG یا WEBP باشد.',

            'cover.max' =>
                'حجم تصویر هیرو نمی‌تواند بیشتر از ۵ مگابایت باشد.',

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'full_name' => trim((string) $this->input('full_name')),
            'email' => strtolower(trim((string) $this->input('email'))),
            'user_phone' => trim((string) $this->input('user_phone')),
            'name' => trim((string) $this->input('name')),
            'phone' => trim((string) $this->input('phone')),
            'address' => trim((string) $this->input('address')),
            'instagram' => trim((string) $this->input('instagram')),
            'description' => trim((string) $this->input('description')),
        ]);
    }
}
