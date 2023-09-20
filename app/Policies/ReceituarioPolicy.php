<?php

namespace App\Policies;

use App\Models\Receituario;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReceituarioPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Receituario');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Receituario $receituario)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Receituario');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Receituario $receituario): bool
    {
        return $user->hasPermissionTo('Edit Receituario');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Receituario $receituario): bool
    {
        return $user->hasPermissionTo('Delete Receituario');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Receituario $receituario)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Receituario $receituario)
    {
        //
    }
}
