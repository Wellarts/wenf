<?php

namespace App\Policies;

use App\Models\OrientacaoPaciente;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrientacaoPacientePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Orientacao-Paciente');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrientacaoPaciente $orientacaoPaciente)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Orientacao-Paciente');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrientacaoPaciente $orientacaoPaciente): bool
    {
        return $user->hasPermissionTo('Edit Orientacao-Paciente');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrientacaoPaciente $orientacaoPaciente): bool
    {
        return $user->hasPermissionTo('Delete Orientacao-Paciente');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrientacaoPaciente $orientacaoPaciente)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrientacaoPaciente $orientacaoPaciente)
    {
        //
    }
}
