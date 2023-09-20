<?php

namespace App\Policies;

use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FornecedorPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Fornecedor');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fornecedor $fornecedor)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Fornecedor');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('Edit Fornecedor');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fornecedor $fornecedor): bool
    {
        return $user->hasPermissionTo('Delete Fornecedor');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fornecedor $fornecedor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fornecedor $fornecedor)
    {
        //
    }
}
