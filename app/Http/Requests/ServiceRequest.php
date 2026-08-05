<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }





    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],


            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],


            'price' => [
                'required',
                'integer',
                'min:0',
            ],


            'duration' => [
                'required',
                'integer',
                'min:5',
            ],


            'is_active' => [
                'nullable',
                'boolean',
            ],


        ];
    }





    public function messages(): array
    {
        return [

            'name.required' =>
                'نام خدمت الزامی است.',


            'price.required' =>
                'قیمت خدمت الزامی است.',


            'price.integer' =>
                'قیمت باید عدد باشد.',


            'duration.required' =>
                'مدت زمان خدمت الزامی است.',


            'duration.min' =>
                'مدت زمان باید حداقل ۵ دقیقه باشد.',

        ];
    }


}
