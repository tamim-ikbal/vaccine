<?php

namespace App\DTO;

use App\Abstract\DTO;
use App\Enums\VerificationMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SendVerificationCodeDTO extends DTO
{
    public string $field_value;
    public string $field_name;
    public string $nid;
    public string $code;
    public VerificationMethod $method;

    public static function create(Request $request): SendVerificationCodeDTO
    {
        $method = self::getMethod($request->get('field_name'));
        return new self([
            'field_value' => self::getFieldValue($request->get('field_value'), $request->get('field_name')),
            'nid'         => $request->get('nid'),
            'field_name'  => $request->get('field_name'),
            'method'      => $method,
            'code'        => self::generateCode($method),
        ]);
    }

    private static function generateCode(?VerificationMethod $method = null): string
    {
        if ($method === VerificationMethod::SMS) {
            return rand(1111, 9999);
        }
        return Str::random(6);
    }

    public function toArray(): array
    {
        return [
            'field'  => $this->field_value,
            'code'   => $this->code,
            'nid'    => $this->nid,
            'method' => $this->method->value
        ];
    }

    private static function getMethod(string $fieldType): VerificationMethod
    {
        if ($fieldType === 'phone') {
            return VerificationMethod::SMS;
        }
        return VerificationMethod::MAIL;
    }

    private static function getFieldValue(string|int $value, string $fieldType): string
    {
        if ($fieldType === 'phone') {
            return Str::startsWith($value, '88') ? $value : '88'.$value;
        }
        return $value;
    }
}
