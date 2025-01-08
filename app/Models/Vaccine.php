<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vaccine extends Model
{

    public function enrolls(): HasMany
    {
        return $this->hasMany(Enroll::class);
    }

    public function doses(): HasMany
    {
        return $this->hasMany(Dose::class);
    }


}
