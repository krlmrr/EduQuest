<?php

namespace Database\Factories;

use App\Models\Advisor;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName().' '.fake()->lastName(),
            'advisor_id' => Advisor::inRandomOrder()->first()->id,
            'email' => fake()->unique()->email(),
            'bio' => fake()->paragraph(),
            'date_of_birth' => fake()->date(),
        ];
    }
}
