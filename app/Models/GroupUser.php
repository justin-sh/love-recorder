<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * @property integer id
 * @property integer user_id
 * @property integer group_id
 */
class GroupUser extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'group_user_role', 'group_user_id');
    }
}
