<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateWorkingHoursRequest extends FormRequest
{
    /**
     * Determine if the authenticated user
     * owns a salon.
     */
    public function authorize(): bool
    {
        return $this->user()?->salon !== null;
    }


    /**
     * Normalize time values before validation.
     *
     * The database may return:
     * 09:00:00
     *
     * while the form works with:
     * 09:00
     */
    protected function prepareForValidation(): void
    {
        $days = $this->input('days', []);

        foreach ($days as $day => $data) {

            if (!is_array($data)) {
                continue;
            }

            foreach ([
                         'start_time',
                         'end_time',
                         'break_start',
                         'break_end',
                     ] as $field) {

                $value = $data[$field] ?? null;

                /*
                |--------------------------------------------------------------------------
                | Empty value
                |--------------------------------------------------------------------------
                */

                if ($value === null || $value === '') {
                    $days[$day][$field] = null;
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Normalize string
                |--------------------------------------------------------------------------
                */

                if (is_string($value)) {

                    $value = trim($value);

                    /*
                    |--------------------------------------------------------------------------
                    | Convert HH:mm:ss → HH:mm
                    |--------------------------------------------------------------------------
                    */

                    if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
                        $value = substr($value, 0, 5);
                    }

                    $days[$day][$field] = $value;
                }
            }
        }

        $this->merge([
            'days' => $days,
        ]);
    }


    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Weekly schedule
            |--------------------------------------------------------------------------
            */

            'days' => [
                'required',
                'array',
                'size:7',
            ],

            'days.*' => [
                'required',
                'array',
            ],


            /*
            |--------------------------------------------------------------------------
            | Closed / Open
            |--------------------------------------------------------------------------
            */

            'days.*.is_closed' => [
                'required',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Working hours
            |--------------------------------------------------------------------------
            */

            'days.*.start_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'days.*.end_time' => [
                'nullable',
                'date_format:H:i',
            ],


            /*
            |--------------------------------------------------------------------------
            | Break
            |--------------------------------------------------------------------------
            */

            'days.*.break_start' => [
                'nullable',
                'date_format:H:i',
            ],

            'days.*.break_end' => [
                'nullable',
                'date_format:H:i',
            ],
        ];
    }


    /**
     * Business validation.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {

            $days = $this->input('days', []);

            foreach ($days as $day => $data) {

                if (!is_array($data)) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Closed state
                |--------------------------------------------------------------------------
                */

                $isClosed = filter_var(
                    $data['is_closed'] ?? false,
                    FILTER_VALIDATE_BOOLEAN
                );


                /*
                |--------------------------------------------------------------------------
                | Closed day
                |--------------------------------------------------------------------------
                |
                | If the salon is closed, we don't require
                | working or break hours.
                |
                */

                if ($isClosed) {
                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Working hours
                |--------------------------------------------------------------------------
                */

                $startTime = $data['start_time'] ?? null;
                $endTime = $data['end_time'] ?? null;


                /*
                |--------------------------------------------------------------------------
                | Start time required
                |--------------------------------------------------------------------------
                */

                if (!$startTime) {

                    $validator->errors()->add(
                        "days.$day.start_time",
                        'ساعت شروع برای روز باز الزامی است.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | End time required
                |--------------------------------------------------------------------------
                */

                if (!$endTime) {

                    $validator->errors()->add(
                        "days.$day.end_time",
                        'ساعت پایان برای روز باز الزامی است.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Start / End order
                |--------------------------------------------------------------------------
                */

                if ($startTime && $endTime) {

                    if ($startTime >= $endTime) {

                        $validator->errors()->add(
                            "days.$day.end_time",
                            'ساعت پایان باید بعد از ساعت شروع باشد.'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Break
                |--------------------------------------------------------------------------
                */

                $breakStart = $data['break_start'] ?? null;
                $breakEnd = $data['break_end'] ?? null;


                /*
                |--------------------------------------------------------------------------
                | If one break value exists,
                | the other one is required.
                |--------------------------------------------------------------------------
                */

                if ($breakStart || $breakEnd) {

                    if (!$breakStart) {

                        $validator->errors()->add(
                            "days.$day.break_start",
                            'شروع استراحت الزامی است.'
                        );
                    }

                    if (!$breakEnd) {

                        $validator->errors()->add(
                            "days.$day.break_end",
                            'پایان استراحت الزامی است.'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Break order
                |--------------------------------------------------------------------------
                */

                if ($breakStart && $breakEnd) {

                    if ($breakStart >= $breakEnd) {

                        $validator->errors()->add(
                            "days.$day.break_end",
                            'پایان استراحت باید بعد از شروع استراحت باشد.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Break must start inside working hours
                    |--------------------------------------------------------------------------
                    */

                    if ($startTime && $breakStart < $startTime) {

                        $validator->errors()->add(
                            "days.$day.break_start",
                            'شروع استراحت باید داخل ساعات کاری باشد.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Break must end inside working hours
                    |--------------------------------------------------------------------------
                    */

                    if ($endTime && $breakEnd > $endTime) {

                        $validator->errors()->add(
                            "days.$day.break_end",
                            'پایان استراحت باید داخل ساعات کاری باشد.'
                        );
                    }
                }
            }
        });
    }


    /**
     * Validation messages.
     */
    public function messages(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Weekly schedule
            |--------------------------------------------------------------------------
            */

            'days.required' =>
                'برنامه هفتگی الزامی است.',

            'days.array' =>
                'ساختار برنامه هفتگی نامعتبر است.',

            'days.size' =>
                'برنامه هفتگی باید شامل ۷ روز باشد.',


            /*
            |--------------------------------------------------------------------------
            | Time format
            |--------------------------------------------------------------------------
            */

            'days.*.start_time.date_format' =>
                'فرمت ساعت شروع نامعتبر است.',

            'days.*.end_time.date_format' =>
                'فرمت ساعت پایان نامعتبر است.',

            'days.*.break_start.date_format' =>
                'فرمت شروع استراحت نامعتبر است.',

            'days.*.break_end.date_format' =>
                'فرمت پایان استراحت نامعتبر است.',
        ];
    }
}
