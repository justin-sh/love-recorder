<?php

use App\Http\Controllers\Children\ChildrenManagementController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('children', '/children/list');

    Route::get('children/list', [ChildrenManagementController::class, 'list'])->name('children.list');

    Route::get('children/add', function () {
        return Inertia::render('children/Add');
    })->name('dashboard');

    Route::post('children/add', [ChildrenManagementController::class, 'create'])->name('children.add');
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
