<?php

namespace App\Services;

use App\Models\Enroll;
use App\Services\Core\CacheKeyService;
use Illuminate\Support\Facades\Cache;

class EnrollService
{
    public static function getEnroll(string $nid, string $dob): ?Enroll
    {
        $cacheKey = CacheKeyService::getEnrollKey($nid, $dob);
        return Cache::remember($cacheKey, 60 * 48, function () use ($nid, $dob) {
            return Enroll::query()
                ->where(['nid' => $nid, 'dob' => $dob])
                ->first();
        });
    }

    public static function clearEnrollCache(string $nid): void
    {
        Cache::forget(CacheKeyService::getEnrollKey($nid));
    }
}
