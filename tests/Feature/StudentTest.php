<?php

use App\Filament\Resources\AdvisorResource\Pages\EditAdvisor;
use App\Filament\Resources\StudentResource;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Models\Course;
use App\Models\Student;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Carbon;
use Livewire\Volt\Volt;

use function Pest\Livewire\livewire;

it('can list students on the homepage', function () {
    $students = Student::factory()->count(10)->create();

    Volt::test('students.index')
        ->assertSee($students[0]->name)
        ->assertSee($students[0]->email)
        ->assertSee($students[0]->bio)
        ->assertDontSee($students[0]->date_of_birth);
});

it('can list students', function () {
    $students = Student::factory()->count(10)->create();

    livewire(StudentResource\Pages\ListStudents::class)
        ->assertCanSeeTableRecords($students);
});

it('can create a student', function () {
    $student = Student::factory()->make();

    livewire(CreateStudent::class)
        ->fillForm([
            'name' => $student->name,
            'email' => $student->email,
            'date_of_birth' => $student->date_of_birth,
            'bio' => $student->bio,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Student::class, [
        'name' => $student->name,
        'email' => $student->email,
        'date_of_birth' => Carbon::parse($student->date_of_birth)->toDateString(),
        'bio' => $student->bio,
    ]);
});

it('can create a student without a bio', function () {
    $student = Student::factory()->make();

    livewire(CreateStudent::class)
        ->fillForm([
            'name' => $student->name,
            'email' => $student->email,
            'date_of_birth' => $student->date_of_birth,
            'bio' => null,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Student::class, [
        'name' => $student->name,
        'email' => $student->email,
        'date_of_birth' => Carbon::parse($student->date_of_birth)->toDateString(),
        'bio' => null,
    ]);
});

it('can validate input', function () {
    $student = Student::factory()->create();

    livewire(EditStudent::class, [
        'record' => $student->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
            'email' => null,
            'date_of_birth' => null,
            'bio' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
        ]);
});

it('can update a student', function () {
    $student = Student::factory()->create();

    livewire(EditStudent::class, [
        'record' => $student->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Test Student',
            'email' => 'test@email.com',
            'date_of_birth' => $student->date_of_birth,
            'bio' => $student->bio,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Student::class, [
        'name' => 'Test Student',
        'email' => 'test@email.com',
        'date_of_birth' => Carbon::parse($student->date_of_birth)->toDateString(),
        'bio' => $student->bio,
    ]);
});

it('can delete an student', function () {
    $student = Student::factory()->create();

    livewire(StudentResource\Pages\EditStudent::class, [
        'record' => $student->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($student);
});

it('can render relation manager for courses', function () {
    $student = Student::factory()
        ->has(Course::factory()->count(10))
        ->create();

    livewire(StudentResource\RelationManagers\CoursesRelationManager::class, [
        'ownerRecord' => $student,
        'pageClass' => EditStudent::class,
    ])
        ->assertSuccessful();
});

it('can list courses', function () {
    $student = Student::factory()
        ->has(Course::factory()->count(10))
        ->create();

    livewire(StudentResource\RelationManagers\CoursesRelationManager::class, [
        'ownerRecord' => $student,
        'pageClass' => EditAdvisor::class,
    ])
        ->assertCanSeeTableRecords($student->courses);
});
