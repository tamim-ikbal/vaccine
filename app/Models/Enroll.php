<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Enroll extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollFactory> */
    use HasFactory, Notifiable;

    public function vaccineCenter(): BelongsTo
    {
        return $this->belongsTo(VaccineCenter::class);
    }

    public function status(): Attribute
    {
        return Attribute::get(function ($value, $attribute) {
            if (!$attribute['schedule_at']) {
                return __('Not Scheduled');
            } elseif (now() > $attribute['schedule_at']) {
                return __('Vaccinated!');
            } else {
                return __('Scheduled');
            }
        });
    }

    protected function casts(): array
    {
        return [
            'schedule_at' => 'datetime',
        ];
    }
}
