<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\SendVerificationCodeAction;
use App\Actions\VerifyVerificationCodeAction;
use App\DTO\SendVerificationCodeDTO;
use App\DTO\VerificationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SendVerificationCodeRequest;
use App\Http\Requests\Api\V1\VerificationCodeRequest;

class EnrollVerificationController extends Controller
{
    public function send(SendVerificationCodeRequest $request, SendVerificationCodeAction $action)
    {
        $DTO = SendVerificationCodeDTO::create($request);

        $action->handle($DTO);

        return response()->json([
            'status'  => true,
            'message' => __('Verification code sent.'),
            'payload' => null
        ]);

    }

    public function verify(VerificationCodeRequest $request, VerifyVerificationCodeAction $action)
    {
        $DTO = VerificationDTO::create($request);

        $action->handle($DTO);

        return response()->json([
            'status'  => true,
            'message' => __('Verification successful.'),
            'payload' => null
        ]);
    }
}
