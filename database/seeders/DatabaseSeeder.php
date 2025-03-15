<?php

namespace Database\Seeders;

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

        Student::factory(100)->create();

        Course::factory(20)->create();
    }
}
