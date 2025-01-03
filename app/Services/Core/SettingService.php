<?php

namespace App\Services\Core;

class SettingService
{
    public static function getRequiredVerifications(): array
    {
        //Note: You must implement the validation system before list here.
        return [
            'email',
        ];
    }
}
