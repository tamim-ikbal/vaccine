<?php

namespace App\Jobs;

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
        private readonly stdClass|Enroll $enroll,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $scheduleAt = now()->addDay()->setTime(10, 0);
        $this->enroll->update(['schedule_at' => $scheduleAt]);
        $this->enroll->notify(new VaccineScheduleDate($this->vaccineCenter, $scheduleAt));
    }
}
