<?php

namespace App\Models;

use App\Gender;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string name
 * @property Gender gender
 * @property Carbon birthday
 * @property int height_dob
 * @property int weight_dob
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
}
