<?php

use App\Filament\Resources\AdvisorResource;
use App\Filament\Resources\AdvisorResource\Pages\CreateAdvisor;
use App\Filament\Resources\AdvisorResource\Pages\EditAdvisor;
use App\Models\Advisor;
use App\Models\Course;
use App\Models\Student;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can list advisors', function () {
    $advisors = Advisor::factory()->count(10)->create();

    livewire(AdvisorResource\Pages\ListAdvisors::class)
        ->assertCanSeeTableRecords($advisors);
});

it('can create an advisor', function () {
    $advisor = Advisor::factory()->make();

    livewire(CreateAdvisor::class)
        ->fillForm([
            'name' => $advisor->name,
            'email' => $advisor->email,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Advisor::class, [
        'name' => $advisor->name,
        'email' => $advisor->email,
    ]);
});

it('can validate input', function () {
    $advisor = Advisor::factory()->create();

    livewire(EditAdvisor::class, [
        'record' => $advisor->getRouteKey(),
    ])
        ->fillForm([
            'name' => null,
            'email' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'name' => 'required',
            'email' => 'required',
        ]);
});

it('can update an advisor', function () {
    $advisor = Advisor::factory()->create();

    livewire(EditAdvisor::class, [
        'record' => $advisor->getRouteKey(),
    ])
        ->fillForm([
            'name' => 'Test User',
            'email' => 'test@email.com',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Advisor::class, [
        'name' => 'Test User',
        'email' => 'test@email.com',
    ]);
});

it('can delete an advisor', function () {
    $advisor = Advisor::factory()->create();

    livewire(AdvisorResource\Pages\EditAdvisor::class, [
        'record' => $advisor->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertModelMissing($advisor);
});

it('can render relation manager for students', function () {
    $advisor = Advisor::factory()
        ->has(Student::factory()->count(10))
        ->create();

    livewire(AdvisorResource\RelationManagers\StudentsRelationManager::class, [
        'ownerRecord' => $advisor,
        'pageClass' => EditAdvisor::class,
    ])
        ->assertSuccessful();
});

it('can list students', function () {
    $advisor = Advisor::factory()
        ->has(Student::factory()->count(10))
        ->create();

    livewire(AdvisorResource\RelationManagers\StudentsRelationManager::class, [
        'ownerRecord' => $advisor,
        'pageClass' => EditAdvisor::class,
    ])
        ->assertCanSeeTableRecords($advisor->students);
});

it('can render relation manager for courses', function () {
    $advisor = Advisor::factory()
        ->has(Course::factory()->count(10))
        ->create();

    livewire(AdvisorResource\RelationManagers\CoursesRelationManager::class, [
        'ownerRecord' => $advisor,
        'pageClass' => EditAdvisor::class,
    ])
        ->assertSuccessful();
});

it('can list courses', function () {
    $advisor = Advisor::factory()
        ->has(Course::factory()->count(10))
        ->create();

    livewire(AdvisorResource\RelationManagers\CoursesRelationManager::class, [
        'ownerRecord' => $advisor,
        'pageClass' => EditAdvisor::class,
    ])
        ->assertCanSeeTableRecords($advisor->courses);
});
