<?php

namespace App\Actions;

use App\DTO\SendVerificationCodeDTO;
use App\Models\Verification;
use App\Notifications\SendVerificationCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendVerificationCodeAction
{
    public function handle(SendVerificationCodeDTO $DTO): void
    {
        //Delete Old Code
        DB::table('verifications')
            ->where(['field' => $DTO->field_value, 'nid' => $DTO->nid])
            ->delete();

        $verification = Verification::create($DTO->toArray());

        Notification::send($verification, new SendVerificationCode());
    }
}
