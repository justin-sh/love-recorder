<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/tenant', function (\Illuminate\Http\Request $request) {

        $user = $request->user();

        return Inertia::render('Tenant', [
            'tenant' => $user->groups()->get(['groups.id', 'name'])
        ]);
    })->name('tenant');

    Route::prefix('{tenant}')->get('dashboard', function () {
        $uGroups = Auth::user()->groups()->get();
        Log::debug(count($uGroups));
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/children.php';
require __DIR__ . '/event.php';
require __DIR__ . '/analysis.php';
