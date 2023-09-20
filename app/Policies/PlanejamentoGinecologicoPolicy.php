<?php

namespace App\Policies;

use App\Models\PlanejamentoGinecologico;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlanejamentoGinecologicoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Planejamento-Ginecologico');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlanejamentoGinecologico $planejamentoGinecologico)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Planejamento-Ginecologico');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlanejamentoGinecologico $planejamentoGinecologico): bool
    {
        return $user->hasPermissionTo('Edit Planejamento-Ginecologico');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlanejamentoGinecologico $planejamentoGinecologico): bool
    {
        return $user->hasPermissionTo('Delete Planejamento-Ginecologico');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PlanejamentoGinecologico $planejamentoGinecologico)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PlanejamentoGinecologico $planejamentoGinecologico)
    {
        //
    }
}
