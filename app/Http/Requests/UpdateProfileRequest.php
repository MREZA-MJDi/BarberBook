<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'full_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($this->user()->id),
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'وارد کردن نام و نام خانوادگی الزامی است.',
            'full_name.string'   => 'نام و نام خانوادگی باید به صورت متن باشد.',
            'full_name.max'      => 'نام و نام خانوادگی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'phone.string' => 'شماره موبایل باید به صورت متن باشد.',
            'phone.max'    => 'شماره موبایل معتبر نیست.',

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email'    => 'فرمت ایمیل صحیح نیست.',
            'email.max'      => 'ایمیل نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'email.unique'   => 'این ایمیل قبلاً توسط کاربر دیگری ثبت شده است.',
        ];
    }
}
