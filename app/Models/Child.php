<?php

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property string name
 * @property Gender gender
 * @property Carbon birthday
 * @property int height_dob
 * @property int weight_dob
 * @property int user_id
 * @property User user
 */
class Child extends Model
{

    protected $table = 'children';

    protected $fillable = [
        'name',
        'gender',
        'birthday',
        'height_dob',
        'weight_dob',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'birthday' => 'datetime',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
