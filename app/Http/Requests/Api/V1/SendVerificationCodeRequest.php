<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\VerificationMethod;
use App\Services\Core\SettingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendVerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'field_value' => [
                'required', Rule::when(
                    $this->field_name === 'phone',
                    ['numeric', 'max_digits:11', 'regex:/^01[3-9][0-9]{8}$/'],
                    ['string', 'email']
                )
            ],
            'field_name'  => ['required', 'string', Rule::in(SettingService::getRequiredVerifications())],
            'nid'         => ['required', 'string']
        ];
    }
}
