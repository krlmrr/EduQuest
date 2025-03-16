<?php

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CourseResource\Pages\CreateCourse;
use App\Filament\Resources\CourseResource\Pages\EditCourse;
use App\Models\Course;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can list courses', function () {
    $courses = Course::factory()->count(10)->create();

    livewire(CourseResource\Pages\ListCourses::class)
        ->assertCanSeeTableRecords($courses);
});

it('can create an course', function () {
    $course = Course::factory()->make();

    livewire(CreateCourse::class)
        ->fillForm([
            'name' => $course->name,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Course::class, [
        'name' => $course->name,
    ]);
});

it('can validate input on courses', function () {
    $course = Course::factory()->create();

    livewire(EditCourse::class, [
        'record' => $course->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
        ]);
});

it('can update a course', function () {
    $course = Course::factory()->create();

    livewire(EditCourse::class, [
        'record' => $course->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Test Course',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Course::class, [
        'name' => 'Test Course',
    ]);
});

it('can delete a course', function () {
    $course = Course::factory()->create();

    livewire(CourseResource\Pages\EditCourse::class, [
        'record' => $course->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($course);
});
