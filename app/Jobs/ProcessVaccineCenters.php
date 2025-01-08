<?php

namespace App\Jobs;

use App\Models\Vaccine;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection as DBCollection;

class ProcessVaccineCenters implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Collection|DBCollection $vaccineCenters,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->vaccineCenters as $vaccineCenter) {
            ScheduleVaccineFirstDose::dispatch($vaccineCenter);
            SchduleVaccineRestDose::dispatch($vaccineCenter);
        }
    }
}
