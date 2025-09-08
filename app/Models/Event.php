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
 * @property array details
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

    protected $attributes = [
        'details' => '{}'
    ];

    protected $casts = [
        'type' => EventType::class,
        'details' => 'array',
        'event_at' => 'datetime',
        'event_end' => 'datetime',
        'event_child_id' => 'integer',
    ];

    public const EVENT_DETAILS = [
        EventType::BottleFeeding->name => ['qty' => ['placeholder' => 'how many ml', 'unit' => 'ml']],
        EventType::BreastFeeding->name => ['qty' => ['placeholder' => 'how many ml breast milk top up by bottle', 'unit' => 'ml']],
        EventType::Weight->name => ['qty' => ['placeholder' => 'how many gram', 'unit' => 'gram']],
        EventType::Height->name => ['qty' => ['placeholder' => 'how many cm', 'unit' => 'cm']],
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'event_child_id');
    }
}
