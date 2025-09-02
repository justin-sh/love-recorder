<?php

namespace App\Http\Resources;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Event $resource
 */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $a = $this->resource->child->birthday->startOfDay();
        $b = $this->resource->event_at->startOfDay();

        $y = (int)$a->diffInYears($b);
        $a = $a->addYears($y);
        $m = (int)$a->diffInMonths($b);
        $a = $a->addMonths($m);
        $d = (int)$a->diffInDays($b);

        return [
            'id'=>$this->resource->id,
            'for'=>$this->resource->child->name,
            'type'=> $this->resource->type->name,
            'event_at'=>$this->resource->event_at->toDateTimeString('minute'),
            'event_at_hr'=> ($y? "{$y}y " : '' ) . ($m? "{$m}m " : '' ) . ($d+1) . 'd',
            'event_end'=>$this->resource->event_end?->toDateTimeString('minute'),
            'note'=>$this->resource->note,
        ];
    }
}
