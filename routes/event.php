<?php

use App\Http\Controllers\ChildEventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('events', [ChildEventController::class, 'index'])->name('event.list');

    Route::get('events/create', [ChildEventController::class, 'create'])->name('event.create');

    Route::post('events', [ChildEventController::class, 'store'])->name('event.store');

    Route::get('events/{id}', [ChildEventController::class, 'edit'])->name('event.edit');
    Route::post('events/{id}', [ChildEventController::class, 'update'])->name('event.update');


});
