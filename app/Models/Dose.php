<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dose extends Model
{
    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

}
