<?php

namespace App\Policies;

use App\Models\FluxoCaixa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FluxoCaixaPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Fluxo-Caixa');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FluxoCaixa $fluxoCaixa)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Fluxo-Caixa');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FluxoCaixa $fluxoCaixa): bool
    {
        return $user->hasPermissionTo('Edit Fluxo-Caixa');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FluxoCaixa $fluxoCaixa): bool
    {
        return $user->hasPermissionTo('Delete Fluxo-Caixa');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FluxoCaixa $fluxoCaixa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FluxoCaixa $fluxoCaixa)
    {
        //
    }
}
