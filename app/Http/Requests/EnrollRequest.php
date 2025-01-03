<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EnrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:100'],
            'email'             => ['required', 'email', 'max:100'],
            'phone'             => ['required', 'numeric', 'max_digits:11', 'regex:/^01[3-9][0-9]{8}$/'],
            'nid'               => [
                'required', 'string', 'regex:/^\w{10}$|^\w{14}$|^\w{17}$/', 'unique:enrolls,nid'
            ],
            'dob'               => ['required','string', 'date_format:Y-m-d'],
            'vaccine_center_id' => ['required', 'integer', 'exists:vaccine_centers,id']
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number is invalid.',
            'nid.regex'   => 'The nid/birth certificate number is invalid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nid'               => 'nid/birth certificate number',
            'vaccine_center_id' => 'vaccine center',
        ];
    }
}
