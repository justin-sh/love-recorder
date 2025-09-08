<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Resources\EventResource;
use App\Models\Child;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ChildEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection|Response
    {

        $data = Event::query()->orderByDesc('event_at')->orderByDesc('id')->cursorPaginate(20);

        if ($request->wantsJson()) {
            return EventResource::collection($data);
        }

        return Inertia::render('event/List', [
            'events' => EventResource::collection($data),
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
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name]),
            'details' => Event::EVENT_DETAILS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $details = [];
        $req = $request->json()->all();
        foreach (Arr::get($req, 'details', []) as $k => $v) {
            if (!empty(trim($k)) && !empty(trim($v['v']))) {
                $details[trim($k)] = $v;
            }
        }

        Arr::forget($req, 'details');

        $event = new Event($req);
        $event->details = $details;
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
            'type' => collect(EventType::cases())->map(fn($e) => ['key' => $e->value, 'value' => $e->name]),
            'details' => Event::EVENT_DETAILS
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $details = [];
        if (!empty($dd = $request->json('details'))) {
            foreach ($dd as $k => $v) {
                if (!empty(trim($k)) && !empty(trim($v['v']))) {
                    $details[trim($k)] = $v;
                }
            }
        }
        $event = Event::find($id);
        $event->details = $details;
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
