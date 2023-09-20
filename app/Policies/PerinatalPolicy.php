<?php

namespace App\Policies;

use App\Models\Perinatal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PerinatalPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Pre-Natal');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Perinatal $perinatal)
    {
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Pre-Natal');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Perinatal $perinatal): bool
    {
        return $user->hasPermissionTo('Edit Pre-Natal');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Perinatal $perinatal): bool
    {
        return $user->hasPermissionTo('Delete Pre-Natal');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Perinatal $perinatal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Perinatal $perinatal)
    {
        //
    }
}
