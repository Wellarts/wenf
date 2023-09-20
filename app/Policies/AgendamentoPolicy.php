<?php

namespace App\Policies;

use App\Models\AgendarAtendimento;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AgendamentoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Agendamento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AgendarAtendimento $agendarAtendimento)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create Agendamento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AgendarAtendimento $agendarAtendimento): bool
    {
        return $user->hasPermissionTo('Edit Agendamento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AgendarAtendimento $agendarAtendimento): bool
    {
        return $user->hasPermissionTo('Delete Agendamento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AgendarAtendimento $agendarAtendimento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AgendarAtendimento $agendarAtendimento)
    {
        //
    }
}
