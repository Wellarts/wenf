<?php

namespace App\Policies;

use App\Models\PlanejamentoReprodutivo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlanejamentoReprodutivoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Planejamento-Reprodutivo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanejamentoReprodutivo $planejamentoReprodutivo)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Planejamento-Reprodutivo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanejamentoReprodutivo $planejamentoReprodutivo): bool
    {
        return $user->hasPermissionTo('Edit Planejamento-Reprodutivo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanejamentoReprodutivo $planejamentoReprodutivo): bool
    {
        return $user->hasPermissionTo('Delete Planejamento-Reprodutivo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanejamentoReprodutivo $planejamentoReprodutivo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanejamentoReprodutivo $planejamentoReprodutivo)
    {
        //
    }
}
