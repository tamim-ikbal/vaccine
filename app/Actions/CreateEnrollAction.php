<?php

namespace App\Actions;

use App\DTO\EnrollDTO;
use App\Models\Enroll;

class CreateEnrollAction
{
    public function handle(EnrollDTO $DTO): void
    {
        Enroll::create($DTO->toArray());
    }
}
