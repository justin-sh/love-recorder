<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Resources\ChildResource;
use App\Http\Resources\EventResource;
use App\Models\Child;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class AnalyseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function weight(Request $request): Response|AnonymousResourceCollection
    {
        $children = Child::all(['id as key', 'name as value']);
        $childId = $request->integer('c_id');
        if ($childId == 0) {
            $childId = $children->first()?->key ?? 0;
        }
        $data = Event::query()
            ->where('event_child_id', $childId)
            ->where('type', EventType::Weight->value)
            ->orderBy('event_at')
            ->orderBy('id')
            ->get(['id', 'event_child_id', 'event_at', 'details']);

        if ($request->wantsJson()) {
            return EventResource::collection($data);
        }

        return Inertia::render('analysis/Weight', [
            'children' => $children,
            'data' => EventResource::collection($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
