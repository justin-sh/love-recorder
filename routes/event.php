<?php

use App\EventType;
use App\Http\Controllers\ChildEventController;
use App\Http\Resources\EventResource;
use App\Models\Child;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

    Route::get('events', [ChildEventController::class, 'index'])->name('event.list');

    Route::get('events/create', [ChildEventController::class, 'create'])->name('event.create');

    Route::post('events', [ChildEventController::class, 'store'])->name('event.store');

    Route::get('events/{id}', [ChildEventController::class, 'edit'])->name('event.edit');
    Route::post('events/{id}', [ChildEventController::class, 'update'])->name('event.update');


});
