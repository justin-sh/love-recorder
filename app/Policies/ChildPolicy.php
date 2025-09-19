<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ChildPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        Log::debug("$user->name checking for the viewAny children]");
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Child $child): bool
    {
        Log::debug("$user->name checking for the view child[$child->name]");
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        Log::debug("$user->name checking for the create child[$child->name]");
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Child $child): bool
    {
        Log::debug("$user->name checking for the update child[$child->name]");
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Child $child): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Child $child): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Child $child): bool
    {
        return false;
    }
}
