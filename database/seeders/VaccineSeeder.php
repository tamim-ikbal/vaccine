<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinopharm = Vaccine::create([
            'name'           => 'Sinopharm',
            'num_of_doses'   => 2,
            'required_doses' => 2
        ]);

        $pfizer = Vaccine::create([
            'name'         => 'Pfizer',
            'num_of_doses' => 2
        ]);

        $sinopharm->doses()->createMany([
            [
                'name'          => 'Dose 1',
                'interval_days' => 30,
                'sequence'      => 1
            ],
            [
                'name'          => 'Dose 2',
                'interval_days' => 30,
                'sequence'      => 2
            ]
        ]);

        $pfizer->doses()->createMany([
            [
                'name'          => 'Dose 1',
                'interval_days' => 30,
                'sequence'      => 1
            ],
            [
                'name'          => 'Dose 2',
                'interval_days' => 30,
                'sequence'      => 2
            ]
        ]);
    }
}
