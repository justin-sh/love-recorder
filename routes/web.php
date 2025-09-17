<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/tenant', function (Request $request) {

        return Inertia::render('Tenant', [
            'tenant' => $request->user()->groups()->get(['groups.id', 'name'])
        ]);
    })->name('tenant');

    Route::prefix('{tenant}')->get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/children.php';
require __DIR__ . '/event.php';
require __DIR__ . '/analysis.php';
