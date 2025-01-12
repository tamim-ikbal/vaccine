<?php

namespace App\Services\Core;

class CacheKeyService
{
    public static function verificationKey(string $nid): string
    {
        return 'verification'.$nid;
    }

    public static function getEnrollKey(string $nid): string
    {
        return sprintf('get_enroll_status_key_%s', $nid);
    }
}
