<?php

use App\EventType;
use App\Http\Controllers\ChildEventController;
use App\Models\Child;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
//    Route::redirect('children', '/children/list');

    Route::get('event/list', [ChildEventController::class, 'index'])->name('event.list');

    Route::get('event/add', function () {
        $data = Child::all(['id as key', 'name as value']);
        return Inertia::render('event/Add', [
            'children' => $data,
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name])
        ]);
    })->name('event.add.get');

    Route::post('event/add', [ChildEventController::class, 'create'])->name('event.add');
//    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//
//    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
//
//    Route::put('settings/password', [PasswordController::class, 'update'])
//        ->middleware('throttle:6,1')
//        ->name('password.update');
//
//    Route::get('settings/appearance', function () {
//        return Inertia::render('settings/Appearance');
//    })->name('appearance');
});
