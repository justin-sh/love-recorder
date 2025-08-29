<?php

namespace App\Http\Resources;

use App\Models\Child;
use Carbon\Carbon;
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
        $a = $this->resource->birthday->startOfDay();
        $b = Carbon::now($a->getTimezone())->startOfDay();

        $y = (int)$a->diffInYears($b);
        $a = $a->addYears($y);
        $m = (int)$a->diffInMonths($b);
        $a = $a->addMonths($m);
        $d = (int)$a->diffInDays($b);
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'gender'=> $this->resource->gender->name,
            'birthday'=>$this->resource->birthday->toDateString(),
            'age'=>['year'=>$y, 'month'=>$m, 'day'=> $d],
            'height'=>$this->resource->height_dob,
            'weight'=>$this->resource->weight_dob,
        ];
    }
}
