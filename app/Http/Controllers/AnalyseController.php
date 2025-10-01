<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Http\Resources\EventResource;
use App\Models\Child;
use App\Models\Event;
use App\Models\TenantHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AnalyseController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function weight(Request $request): Response|AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user();

        $children = Child::query()
            ->where('tenant_id', TenantHelper::getRawId())
            ->whereIn('tenant_id', $user->tenants()->pluck('tenants.id'))
            ->get(['id as key', 'name as value']);
        $childId = $request->integer('c_id');
        if ($childId == 0) {
            $childId = $children->first()?->key ?? 0;
        }
        if ($children->pluck('key')->doesntContain($childId)) {
            $childId = 0;
        }
        $data = Event::query()
            ->where('event_child_id', $childId)
            ->where('type', EventType::Weight->value)
            ->where('tenant_id', TenantHelper::getRawId())
            ->whereIn('tenant_id', $user->tenants()->pluck('tenants.id'))
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
     * Show the form for creating a new resource.
     */
    public function feeding(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $children = Child::query()
            ->where('tenant_id', TenantHelper::getRawId())
            ->whereIn('tenant_id', $user->tenants()->pluck('tenants.id'))
            ->get(['id as key', 'name as value']);

        $childId = $request->integer('c_id');
        if ($childId == 0) {
            $childId = $children->first()?->key ?? 0;
        }
        if ($children->pluck('key')->doesntContain($childId)) {
            $childId = 0;
        }
        $data = Event::query()
            ->select(DB::raw('date(event_at) as `day`'), 'type', DB::raw('count(*) as `count`'))
            ->where('event_child_id', $childId)
            ->whereIn('type', [EventType::BottleFeeding->value, EventType::BreastFeeding->value, EventType::Wee->value, EventType::Poo->value])
            ->where('tenant_id', TenantHelper::getRawId())
            ->whereIn('tenant_id', $user->tenants()->pluck('tenants.id'))
            ->groupBy([DB::raw('date(event_at)'), 'type'])
            ->orderBy('day')
            ->orderBy('type')
            ->get();

        $rv = $data->groupBy('day')->map(function ($v) {
            $tc = [];
            foreach ($v as $x) {
                $tc[$x->type->value] = $x->count;
            }
            return $tc;
        });
        // Log::debug($rv);

        return json_encode($rv);

    }
}
