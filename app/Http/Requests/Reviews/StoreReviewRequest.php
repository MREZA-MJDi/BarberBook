<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'salon_id' => [
                'required',
                'integer',
                'exists:salons,id',
            ],

            'booking_id' => [
                'required',
                'integer',
                'exists:bookings,id',
            ],

            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'salon_id.required' => 'انتخاب سالن الزامی است.',
            'salon_id.exists' => 'سالن مورد نظر یافت نشد.',

            'booking_id.required' => 'رزرو الزامی است.',
            'booking_id.exists' => 'رزرو مورد نظر یافت نشد.',

            'rating.required' => 'امتیاز الزامی است.',
            'rating.integer' => 'امتیاز باید عدد باشد.',
            'rating.between' => 'امتیاز باید بین ۱ تا ۵ باشد.',

            'comment.string' => 'متن نظر باید معتبر باشد.',
            'comment.max' => 'متن نظر نمی‌تواند بیشتر از ۲۰۰۰ کاراکتر باشد.',
        ];
    }
}
