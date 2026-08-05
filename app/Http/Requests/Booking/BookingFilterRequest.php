<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingFilterRequest extends FormRequest
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

            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
                'in:pending,approved,completed,rejected,cancelled',
            ],

            'date' => [
                'nullable',
                'date',
            ],

            'sort' => [
                'nullable',
                'in:newest,oldest',
            ],

        ];
    }
}
