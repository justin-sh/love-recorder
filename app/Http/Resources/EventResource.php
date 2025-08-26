<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Event $resource
 */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->resource->id,
            'for'=>$this->resource->child->name,
            'type'=> $this->resource->type->name,
            'event_at'=>$this->resource->event_at->toDateTimeString('minute'),
            'event_end'=>$this->resource->event_end?->toDateTimeString('minute'),
            'note'=>$this->resource->note,
        ];
    }
}
