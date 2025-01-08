<?php

namespace App\Console\Commands;

use App\Jobs\ProcessVaccineCenters;
use App\Models\Vaccine;
use App\Models\VaccineCenter;
use Illuminate\Console\Command;

class VaccineSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccine:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Vaccine Date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->schedule();
    }

    private function schedule(): void
    {
        VaccineCenter::query()
            ->select('id', 'name', 'district', 'daily_limit')
            ->whereHas('enrolls')
            ->chunkById(50, function ($vaccineCenters) {
                ProcessVaccineCenters::dispatch($vaccineCenters);
            }, 'id');
    }
}
