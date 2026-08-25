<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSalonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $salon = $this->route('salon');

        $userId = $salon?->user_id;


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
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'user_phone' => [
                'required',
                'string',
                'max:30',
            ],

            'password' => [
                'nullable',
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

            'is_active' => [
                'nullable',
                'boolean',
            ],

        ];
    }


    /**
     * Custom validation messages.
     */
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
                'این ایمیل قبلاً توسط کاربر دیگری استفاده شده است.',

            'user_phone.required' =>
                'شماره موبایل آرایشگر را وارد کنید.',

            'name.required' =>
                'نام سالن را وارد کنید.',

            'password.min' =>
                'رمز عبور باید حداقل ۸ کاراکتر باشد.',

            'password.confirmed' =>
                'تکرار رمز عبور با رمز عبور یکسان نیست.',

            'address.max' =>
                'آدرس واردشده بیش از حد مجاز طولانی است.',

            'instagram.max' =>
                'آدرس اینستاگرام بیش از حد مجاز طولانی است.',

            'description.max' =>
                'توضیحات بیش از حد مجاز طولانی است.',

        ];
    }


    /**
     * Prepare input before validation.
     */
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
