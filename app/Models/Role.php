<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string name
 */
class Role extends Model
{
    protected $fillable = ['name'];

    public function permissions():BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
