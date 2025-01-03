<?php

namespace App\DTO;

use App\Abstract\DTO;
use App\Enums\VerificationMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerificationDTO extends DTO
{
    public string $field_value;
    public string $field_name;
    public string $nid;
    public string $code;

    public static function create(Request $request): VerificationDTO
    {
        return new self([
            'field_value' => $request->get('field_value'),
            'nid'         => $request->get('nid'),
            'field_name'  => $request->get('field_name'),
            'code'        => $request->get('code'),
        ]);
    }

    public function toArray(): array
    {
        return [
            'field' => $this->field_value,
            'code'  => $this->code,
            'nid'   => $this->nid,
        ];
    }
}
