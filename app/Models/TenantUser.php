<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * @property integer user_id
 * @property integer group_id
 */
class TenantUser extends Pivot
{
    public $timestamps = false;
}
