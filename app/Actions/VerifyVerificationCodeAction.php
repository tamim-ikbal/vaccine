<?php

namespace App\Actions;

use App\DTO\VerificationDTO;
use App\Models\Verification;
use App\Services\VerificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VerifyVerificationCodeAction
{
    public function handle(VerificationDTO $DTO): void
    {
        //Check Is Verified
        $verification = Verification::query()
            ->where('field', $DTO->field_value)
            ->where('nid', $DTO->nid)
            ->first();

        $validity = Carbon::now()->subMinutes(6);

        if (!$verification
            || $verification->code !== $DTO->code
        ) {
            throw ValidationException::withMessages([
                'code' => __('Verification code is invalid.'),
            ]);
        }

        VerificationService::setVerified(nid: $DTO->nid, field: $DTO->field_name);

        //Delete Code
        Verification::query()->where(['nid' => $DTO->nid, 'field' => $DTO->field_value])->delete();
    }
}
