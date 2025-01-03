<?php

namespace Database\Seeders;

use App\Models\Enroll;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enroll::factory(200)->create([
            //'schedule_at' => fake()->dateTimeBetween('-1 week', '+1 week')
        ]);
    }
}
