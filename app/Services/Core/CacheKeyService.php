<?php

namespace App\Services\Core;

class CacheKeyService
{
    public static function verificationKey(string $nid): string
    {
        return 'verification'.$nid;
    }
}
