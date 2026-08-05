<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingHourRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }





    public function rules(): array
    {
        return [


            'day_of_week' => [
                'required',
                'integer',
                'between:0,6',
            ],



            'start_time' => [
                'nullable',
                'date_format:H:i',
            ],



            'end_time' => [
                'nullable',
                'date_format:H:i',
                'after:start_time',
            ],



            'break_start' => [
                'nullable',
                'date_format:H:i',
            ],



            'break_end' => [
                'nullable',
                'date_format:H:i',
                'after:break_start',
            ],



            'is_closed' => [
                'nullable',
                'boolean',
            ],


        ];
    }







    public function messages(): array
    {
        return [


            'day_of_week.required' =>
                'انتخاب روز الزامی است.',



            'end_time.after' =>
                'ساعت پایان باید بعد از شروع باشد.',



            'break_end.after' =>
                'پایان استراحت باید بعد از شروع استراحت باشد.',


        ];
    }


}
