<?php

use App\EventType;
use App\Http\Controllers\ChildEventController;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {

    Route::get('event/list', [ChildEventController::class, 'index'])->name('event.list');

    Route::get('event/add', function (Request $request) {

        $data = Child::all(['id as key', 'name as value']);

        $defaultChildId = $request->integer('c_id');
        $defaultChild = null;
        if($defaultChildId){
            $defaultChild = $data->first(fn($c)=>$c->key == $defaultChildId);
        }

        return Inertia::render('event/Add', [
            'defaultChild' => $defaultChild,
            'children' => $data,
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name])
        ]);
    })->name('event.add.get');

    Route::post('event/add', [ChildEventController::class, 'create'])->name('event.add');

});
