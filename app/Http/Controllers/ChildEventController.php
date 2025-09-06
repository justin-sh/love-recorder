<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Resources\EventResource;
use App\Models\Child;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChildEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $data = EventResource::collection(Event::all()->sortByDesc(['event_at', 'id']));
        return Inertia::render('event/List', [
            'events' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('event/CreateUpdate', [
            'defaultChildId' => $request->integer('c_id'),
            'children' => Child::all(['id as key', 'name as value']),
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $event = new Event($request->json()->all());
        $event->save();

        return to_route('event.list');
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
    public function edit(string $id): Response
    {
        $data = Child::all(['id as key', 'name as value']);
        $event = Event::find($id);

        return Inertia::render('event/CreateUpdate', [
            'event' => new EventResource($event),
            'children' => $data,
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);
        $event->update($request->json()->all());

        return to_route('event.list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
