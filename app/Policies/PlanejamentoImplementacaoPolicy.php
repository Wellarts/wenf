<?php

namespace App\Policies;

use App\Models\PlanejamentoImplementacao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlanejamentoImplementacaoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Implementacao');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanejamentoImplementacao $planejamentoImplementacao)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Implementacao');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanejamentoImplementacao $planejamentoImplementacao): bool
    {
        return $user->hasPermissionTo('Edit Implementacao');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanejamentoImplementacao $planejamentoImplementacao): bool
    {
        return $user->hasPermissionTo('Delete Implementacao');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanejamentoImplementacao $planejamentoImplementacao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanejamentoImplementacao $planejamentoImplementacao)
    {
        //
    }
}
