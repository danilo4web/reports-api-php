<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'report_id' => $this->faker->numberBetween(1, Report::count()),
            'email' => fake()->unique()->safeEmail(),
            'cron' => '* * * * *'
        ];
    }
}
