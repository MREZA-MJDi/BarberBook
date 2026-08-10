<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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

            /*
            |--------------------------------------------------------------------------
            | Service
            |--------------------------------------------------------------------------
            */

            'service_id' => [
                'required',
                'integer',
            ],

            /*
            |--------------------------------------------------------------------------
            | Booking Date
            |--------------------------------------------------------------------------
            |
            | Date is received from the UI in Jalali format.
            |
            | Example:
            | 1405/05/25
            |
            | The actual Jalali → Gregorian conversion is handled
            | by BookingController.
            |
            */

            'booking_date' => [
                'required',
                'string',
                'max:10',
            ],

            /*
            |--------------------------------------------------------------------------
            | Booking Time
            |--------------------------------------------------------------------------
            */

            'booking_time' => [
                'required',
                'date_format:H:i',
            ],

            /*
            |--------------------------------------------------------------------------
            | Customer Name
            |--------------------------------------------------------------------------
            */

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Customer Phone
            |--------------------------------------------------------------------------
            */

            'customer_phone' => [
                'required',
                'string',
                'max:30',
            ],

            /*
            |--------------------------------------------------------------------------
            | Customer Note
            |--------------------------------------------------------------------------
            */

            'customer_note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'service_id.required' =>
                'لطفاً یک سرویس انتخاب کنید.',

            'service_id.integer' =>
                'سرویس انتخاب‌شده معتبر نیست.',

            'booking_date.required' =>
                'لطفاً تاریخ رزرو را انتخاب کنید.',

            'booking_date.string' =>
                'فرمت تاریخ رزرو معتبر نیست.',

            'booking_date.max' =>
                'تاریخ رزرو معتبر نیست.',

            'booking_time.required' =>
                'لطفاً ساعت رزرو را انتخاب کنید.',

            'booking_time.date_format' =>
                'فرمت ساعت رزرو باید به صورت ساعت:دقیقه باشد.',

            'customer_name.required' =>
                'لطفاً نام مشتری را وارد کنید.',

            'customer_name.string' =>
                'نام مشتری معتبر نیست.',

            'customer_name.max' =>
                'نام مشتری نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'customer_phone.required' =>
                'لطفاً شماره موبایل مشتری را وارد کنید.',

            'customer_phone.string' =>
                'شماره موبایل مشتری معتبر نیست.',

            'customer_phone.max' =>
                'شماره موبایل مشتری نمی‌تواند بیشتر از ۳۰ کاراکتر باشد.',

            'customer_note.string' =>
                'توضیحات مشتری باید به صورت متن باشد.',

            'customer_note.max' =>
                'توضیحات مشتری نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'service_id' =>
                'سرویس',

            'booking_date' =>
                'تاریخ رزرو',

            'booking_time' =>
                'ساعت رزرو',

            'customer_name' =>
                'نام مشتری',

            'customer_phone' =>
                'شماره موبایل',

            'customer_note' =>
                'توضیحات مشتری',
        ];
    }
}
