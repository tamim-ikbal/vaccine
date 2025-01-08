<?php

namespace App\Jobs;

use App\Models\Dose;
use App\Models\Enroll;
use App\Models\VaccineCenter;
use App\Services\DoseService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SchduleVaccineRestDose implements ShouldQueue
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
    public function handle(DoseService $doseService): void
    {
        $processed = 0;
        Enroll::query()
            ->select(['id', 'vaccine_center_id', 'name', 'nid', 'email', 'phone', 'dob'])
            ->where(function ($builder) {
                $builder->where('vaccine_center_id', $this->vaccineCenter->id)
                    ->whereHas('lastDose', function ($builder) {
                        $builder->whereNotNull('vaccinated_at');
                    });
            })->chunkById(50, function ($enrolls) use (&$processed, $doseService) {
                foreach ($enrolls as $enroll) {

                    if ($this->vaccineCenter->daily_limit <= $processed) {
                        return false;
                    }
                    $lastDose = $enroll->lastDose;

                    //Init Dose Service
                    $doseService->make($lastDose->dose_id);

                    $dose = $doseService->getDose();
                    $nextDose = $doseService->nextDose();

                    if (!$dose || !$nextDose) {
                        continue;
                    }

                    //Same Dose Sequence
                    if ($dose->sequence >= $nextDose->sequence) {
                        continue;
                    }

                    //Interval Not passed
                    if (now() <= $lastDose->vaccinated_at->addDays($dose->interval_days)) {
                        continue;
                    }

                    ScheduleVaccineDate::dispatch($this->vaccineCenter, $enroll, $nextDose);

                    $processed++;
                }
            });
    }
}
