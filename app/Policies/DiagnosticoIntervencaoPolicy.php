<?php

namespace App\Policies;

use App\Models\DiagnosticoIntervencao;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DiagnosticoIntervencaoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View Diagnostico');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DiagnosticoIntervencao $diagnosticoIntervencao)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->hasPermissionTo('Create Diagnostico');
    }
    

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DiagnosticoIntervencao $diagnosticoIntervencao): bool
    {
        return $user->hasPermissionTo('Edit Diagnostico');
    }
    

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DiagnosticoIntervencao $diagnosticoIntervencao): bool
    {
        return $user->hasPermissionTo('Delete Diagnostico');
    }
    

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DiagnosticoIntervencao $diagnosticoIntervencao)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DiagnosticoIntervencao $diagnosticoIntervencao)
    {
        //
    }
}
