<?php

namespace Database\Factories;

use App\Models\Advisor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'advisor_id' => Advisor::inRandomOrder()->first()->id,

            // Create a fake course title with a random amount of words (between 2 and 5 words),
            // and capitalize them to make them look like real course titles.
            'name' => Str::title(fake()->words(fake()->numberBetween(2, 5), true)),
        ];
    }
}
