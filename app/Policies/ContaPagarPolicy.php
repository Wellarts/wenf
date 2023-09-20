<?php

namespace App\Policies;

use App\Models\ContasPagar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContaPagarPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Conta-Pagar');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContasPagar $contasPagar)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Conta-Pagar');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContasPagar $contasPagar): bool
    {
        return $user->hasPermissionTo('Edit Conta-Pagar');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContasPagar $contasPagar): bool
    {
        return $user->hasPermissionTo('Delete Conta-Pagar');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContasPagar $contasPagar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContasPagar $contasPagar)
    {
        //
    }
}
