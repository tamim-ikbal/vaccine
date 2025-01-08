<?php

namespace App\Services;

use App\Models\Dose;

class DoseService
{
    private ?Dose $dose = null;

    public function getDose(): Dose|null
    {
        return $this->dose;
    }

    public function nextDose(): Dose|null
    {
        if (!$this->dose) {
            return null;
        }
        return Dose::query()
            ->where('vaccine_id', $this->dose->vaccine_id)
            ->where('sequence', $this->dose->sequence + 1)
            ->first();
    }

    public function make(int $doseId)
    {
        return $this->dose = Dose::query()->find($doseId);
    }

}
