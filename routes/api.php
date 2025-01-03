<?php

use App\Http\Controllers\Api\V1\EnrollController;
use App\Http\Controllers\Api\V1\EnrollVerificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::prefix('enrolls')->name('enrolls.')->group(function () {
        Route::post('status', [EnrollController::class, 'status'])
            ->middleware(['throttle:enroll.status'])
            ->name('status');

        //Verify
        Route::prefix('verify')->name('verify.')->group(function () {
            Route::post('send', [EnrollVerificationController::class, 'send'])
                ->middleware(['throttle:verification.send'])
                ->name('send');
            Route::post('verify', [EnrollVerificationController::class, 'verify'])
                ->middleware(['throttle:verification.verify'])
                ->name('verify');
        });
    });

});
