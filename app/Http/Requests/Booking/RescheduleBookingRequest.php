<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class RescheduleBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
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

            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'booking_time' => [
                'required',
                'date_format:H:i',
            ],

            'barber_note' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ];
    }
}
