<?php

namespace App\Models;

use App\Enums\EventType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property integer event_child_id
 * @property Child child
 * @property EventType type
 * @property Carbon event_at
 * @property Carbon event_end
 * @property string note
 */
class Event extends Model
{
    protected $fillable = [
        'event_child_id',
        'type',
        'event_at',
        'event_end',
        'note',
    ];

    protected $casts = [
        'type' => EventType::class,
        'event_at' => 'datetime',
        'event_end' => 'datetime',
        'event_child_id' => 'integer',
    ];

    public function child():BelongsTo
    {
        return $this->belongsTo(Child::class, 'event_child_id');
    }
}
