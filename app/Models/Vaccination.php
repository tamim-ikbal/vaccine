<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Vaccination extends Model
{
    public function enroll(): BelongsTo
    {
        return $this->belongsTo(Enroll::class);
    }

    public function dose(): BelongsTo
    {
        return $this->belongsTo(Dose::class);
    }

    public function vaccine(): HasOneThrough
    {
        return $this->hasOneThrough(Vaccine::class, Dose::class);
    }

    protected function casts(): array
    {
        return [
            'vaccinated_at' => 'datetime',
            'schedule_at'   => 'datetime',
        ];
    }
}
