<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VaccineCenter extends Model
{
    /** @use HasFactory<\Database\Factories\VaccineCenterFactory> */
    use HasFactory;

    public function enrolls(): HasMany
    {
        return $this->hasMany(Enroll::class);
    }
}
