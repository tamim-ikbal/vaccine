<?php

namespace App\Http\Controllers;

use App\Actions\CreateEnrollAction;
use App\DTO\EnrollDTO;
use App\Http\Requests\EnrollRequest;
use App\Models\VaccineCenter;
use App\Services\Core\SettingService;
use App\Services\VerificationService;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EnrollController
{
    public function index()
    {
        return Inertia::render('Enroll/Index', [
            'vaccineCenters' => Inertia::defer(fn() => VaccineCenter::query()->select('name', 'id')->get()),
            'toVerify'       => SettingService::getRequiredVerifications()
        ]);
    }

    public function store(EnrollRequest $request, CreateEnrollAction $action)
    {
        $DTO = EnrollDTO::createFromRequest($request);

        if (!VerificationService::isVerified($DTO->nid)) {
            throw ValidationException::withMessages([
                'nid' => __('Please verify all required fields.')
            ]);
        }

        $action->handle($DTO);

        return redirect()->route('home');
    }
}
