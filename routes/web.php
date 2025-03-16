<?php

use Livewire\Volt\Volt;

Volt::route('/', 'students.index')
    ->name('students.index');

require __DIR__.'/auth.php';
