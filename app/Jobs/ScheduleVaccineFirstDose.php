<?php

namespace App\Jobs;

use App\Models\Enroll;
use App\Models\VaccineCenter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use stdClass;

class ScheduleVaccineFirstDose implements ShouldQueue
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
            ->select(['id', 'vaccine_center_id', 'name', 'nid', 'email', 'phone', 'dob'])
            ->where(function ($builder) {
                $builder->where('vaccine_center_id', $this->vaccineCenter->id)
                    ->whereDoesntHave('vaccinations');
            })->chunkById(50, function ($enrolls) use (&$processed) {
                foreach ($enrolls as $enroll) {
                    if ($this->vaccineCenter->daily_limit <= $processed) {
                        return false;
                    }

                    ScheduleVaccineDate::dispatch($this->vaccineCenter, $enroll);

                    $processed++;
                }
            });
    }

//    public function handle(): void
//    {
//        $processed = 0;
//        Enroll::query()
//            ->select(['id', 'vaccine_center_id', 'name', 'nid', 'email', 'phone', 'dob'])
//            ->where(function ($builder) {
//                $builder->where('vaccine_center_id', $this->vaccineCenter->id)
//                    ->when(1 < $this->dose->sequence, function ($query) {
//                        $query->where('vaccine_id', $this->vaccine->id)
//                            ->whereHas('lastDose', function ($query) {
//                                $query->whereNotNull('vaccinated_at');
//                            });
//                    })->when(1 >= $this->dose->sequence, function ($query) {
//                        $query->whereDoesntHave('vaccinations');
//                    });
//
//            })->chunkById(50, function ($enrolls) use (&$processed) {
//                foreach ($enrolls as $enroll) {
//
//                    if ($this->vaccineCenter->daily_limit < $processed) {
//                        return false;
//                    }
//
//                    //When First Dose
//                    if (1 >= $this->dose->sequence) {
//                        $enroll->vaccinations()->create([
//                            'schedule_at' => now()->addDay()->setTime(10, 0)
//                        ]);
//                        $processed++;
//                        continue;
//                    }
//
//                    $lastDose = $enroll->lastDose;
//                    if ($lastDose->dose->sequence >= $this->dose->sequence) {
//                        continue;
//                    }
//
//                    if (now() > $lastDose->vaccinated_at->addDays($this->dose->interval_days)) {
//                        $enroll->vaccinations()->create([
//                            'dose_id'     => $this->dose->id,
//                            'schedule_at' => now()->addDay()->setTime(10, 0)
//                        ]);
//                    }
//                    $processed++;
//                }
//            });
//    }
}
