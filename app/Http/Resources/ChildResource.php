<?php

namespace App\Http\Resources;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Child $resource
 */
class ChildResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'gender'=> $this->resource->gender->name,
            'birthday'=>$this->resource->birthday->toDateString(),
            'height'=>$this->resource->height_dob,
            'weight'=>$this->resource->weight_dob,
        ];
    }
}
