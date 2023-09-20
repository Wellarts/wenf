<?php

namespace App\Policies;

use App\Models\Amamentacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AmamentacaoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Amamentacao');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Amamentacao $amamentacao)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Amamentacao');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Amamentacao $amamentacao): bool
    {
        return $user->hasPermissionTo('Edit Amamentacao');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Amamentacao $amamentacao): bool
    {
        return $user->hasPermissionTo('Delete Amamentacao');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Amamentacao $amamentacao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Amamentacao $amamentacao)
    {
        //
    }
}
