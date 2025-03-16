<?php

use App\Models\Student;
use function Livewire\Volt\{mount, state, title};

title(fn() => 'Students | EduQuest');

state([
    'students' => []
]);

mount(function () {
    $this->students = Student::query()
        ->select(['name', 'email', 'bio'])
        ->orderBy('name')
        ->get();
});

function getInitials($name)
{
    $names = preg_split("/\s+/", $name);
    $initials = "";

    foreach ($names as $name) {
        $initials .= $name[0];
    }

    return $initials;
}
?>

<div>
    <flux:heading size="lg">
        Students
    </flux:heading>

    <div class="flex flex-wrap gap-4 my-8">
        @foreach ($students as $student)
            <x-containers.card>
                <div class="flex items-center gap-3">
                    @if(!empty($student->getMedia("*")->first()))
                        <img src="{{ $student->getMedia("*")->first()->getFullUrl() }}"
                            alt="{{ $student->name }}'s profile photo" class="w-10 h-10 rounded-full" />
                    @else
                        <x-containers.initials :initials="getInitials($student->name)" />
                    @endif

                    <p class="flex flex-col">
                        <span class="font-bold">
                            {{  $student->name }}
                        </span>

                        {{ $student->email  }}
                    </p>
                </div>

                <p class="mt-4">
                    {{ $student->bio  }}
                </p>
            </x-containers.card>
        @endforeach
    </div>
</div>
