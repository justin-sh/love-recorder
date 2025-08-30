<?php

use App\Http\Controllers\Children\ChildrenManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('children', '/children/list');

    Route::get('children', [ChildrenManagementController::class, 'list'])->name('children.list');

    Route::get('children/create', function () {
        return Inertia::render('children/Create');
    })->name('children.create');

    Route::post('children', [ChildrenManagementController::class, 'store'])->name('children.store');

});
