<?php

use App\Http\Controllers\AnalyseController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('analysis')->group(function () {
    Route::redirect('', 'analysis/weight');

    Route::get('weight', [AnalyseController::class, 'weight'])->name('analysis.weight');
    Route::get('feeding', [AnalyseController::class, 'feeding'])->name('analysis.feeding');
});
