<?php

namespace App\Services;

use App\Services\Core\CacheKeyService;
use App\Services\Core\SettingService;
use Illuminate\Support\Facades\Cache;

class VerificationService
{
    public static function setVerified(string $nid, string $field): void
    {
        $verified = static::getVerified($nid);
        Cache::put(static::getCacheKey($nid), [...$verified, $field], 60 * 60);
    }

    public static function isVerified(string $nid): bool
    {
        $verified = static::getVerified($nid);
        $toVerify = SettingService::getRequiredVerifications() ?: [];

        if (0 >= count($toVerify)) {
            return true;
        }

        return array_all($toVerify, fn($value) => in_array($value, $verified));
    }

    public static function remainingVerification(string $nid): array
    {
        $verified = static::getVerified($nid);
        $toVerify = SettingService::getRequiredVerifications() ?: [];
        return array_diff($toVerify, $verified);
    }

    public static function getVerified(string $nid): array
    {
        return Cache::get(CacheKeyService::verificationKey($nid)) ?: [];
    }

    protected static function getCacheKey(string $nid): string
    {
        return CacheKeyService::verificationKey($nid);
    }

}
