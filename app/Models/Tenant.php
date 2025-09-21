<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string description
 */
class Tenant extends Model
{
    protected $fillable = ['name', 'description'];
}
