<?php

namespace Database\Factories;

use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enroll>
 */
class EnrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vaccineCenters = VaccineCenter::query()->pluck('id');
        return [
            'vaccine_center_id' => $this->faker->randomElement($vaccineCenters),
            'name'              => $this->faker->name,
            'email'             => $this->faker->safeEmail(),
            'phone'             => '017'.$this->faker->randomNumber(8),
            'nid'               => $this->faker->unique()->numerify('##############'),
            'dob'               => $this->faker->dateTimeBetween('-30 years', '-16 years')->format('Y-m-d'),
            'schedule_at'       => null
        ];
    }
}
