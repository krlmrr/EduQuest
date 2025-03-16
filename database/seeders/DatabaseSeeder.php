<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        Advisor::factory(20)->create();

        $students = Student::factory(100)->create();

        Course::factory(20)->create();

        $students->map(function ($student) {
            $courses = Course::query()
                ->inRandomOrder()
                ->get()
                ->take(fake()->numberBetween(3, 10));

            $courses->each(function ($course) use ($student) {
                $student->courses()->attach($course->id);
            });
        });
    }
}
