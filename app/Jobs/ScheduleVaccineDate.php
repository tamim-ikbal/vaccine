<?php

namespace App\Jobs;

use App\Models\Dose;
use App\Models\Enroll;
use App\Models\VaccineCenter;
use App\Notifications\VaccineScheduleDate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use stdClass;

class ScheduleVaccineDate implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly stdClass|VaccineCenter $vaccineCenter,
        private readonly Enroll $enroll,
        private readonly null|stdClass|Dose $dose = null,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $scheduleAt = now()->addDay()->setTime(10, 0);

        $this->enroll->vaccinations()->create([
            'schedule_at' => $scheduleAt,
            'dose_id'     => $this->dose?->id ?? null,
        ]);

        $this->enroll->notify(new VaccineScheduleDate($this->vaccineCenter, $scheduleAt, $this->dose));
    }
}
