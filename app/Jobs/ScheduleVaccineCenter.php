<?php

namespace App\Jobs;

use App\Models\Enroll;
use App\Models\VaccineCenter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use stdClass;

class ScheduleVaccineCenter implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly stdClass|VaccineCenter $vaccineCenter,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $processed = 0;
        Enroll::query()
            ->select(['id', 'vaccine_center_id', 'schedule_at', 'name', 'nid', 'email', 'phone', 'dob'])
            ->where(function ($builder) {
                $builder->where('vaccine_center_id', $this->vaccineCenter->id)
                    ->whereNull('schedule_at');
            })->chunkById(50, function ($enrolls) use (&$processed) {
                foreach ($enrolls as $enroll) {
                    if ($this->vaccineCenter->daily_limit < $processed) {
                        return false;
                    }
                    ScheduleVaccineDate::dispatch($this->vaccineCenter, $enroll);
                    $processed++;
                }
            });
    }
}
