<?php

namespace App\Http\Requests\PublicBooking;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicBookingRequest extends FormRequest
{
    /**
     * Public booking does not require authentication.
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
        return [

            /*
            |--------------------------------------------------------------------------
            | Salon
            |--------------------------------------------------------------------------
            |
            | The salon is resolved from the public salon route.
            | It is intentionally NOT trusted from the customer form.
            |
            */

            'service_id' => [
                'required',
                'integer',
            ],

            /*
            |--------------------------------------------------------------------------
            | Booking Date
            |--------------------------------------------------------------------------
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
                'لطفاً یک خدمت را انتخاب کنید.',

            'service_id.integer' =>
                'خدمت انتخاب‌شده معتبر نیست.',

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
                'لطفاً نام خود را وارد کنید.',

            'customer_name.string' =>
                'نام واردشده معتبر نیست.',

            'customer_name.max' =>
                'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'customer_phone.required' =>
                'لطفاً شماره موبایل خود را وارد کنید.',

            'customer_phone.string' =>
                'شماره موبایل واردشده معتبر نیست.',

            'customer_phone.max' =>
                'شماره موبایل نمی‌تواند بیشتر از ۳۰ کاراکتر باشد.',

            'customer_note.string' =>
                'توضیحات باید به صورت متن باشد.',

            'customer_note.max' =>
                'توضیحات نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'service_id' =>
                'خدمت',

            'booking_date' =>
                'تاریخ رزرو',

            'booking_time' =>
                'ساعت رزرو',

            'customer_name' =>
                'نام',

            'customer_phone' =>
                'شماره موبایل',

            'customer_note' =>
                'توضیحات',
        ];
    }
}
