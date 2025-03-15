<?php

namespace Database\Factories;

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
            // Create a fake course title with a random amount of words (between 2 and 5 words),
            // and capitalize them to make them look like real course titles.
            'name' => Str::title(fake()->words(fake()->numberBetween(2, 5), true)),
        ];
    }
}
