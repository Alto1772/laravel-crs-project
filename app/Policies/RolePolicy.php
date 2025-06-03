<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('view all roles')
            ? Response::allow()
            : Response::deny('You do not have permission to view roles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('Super Admin') ? Response::allow()
            : Response::deny('Only Super Admins can create any roles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): Response
    {
        if ($role->name == 'Super Admin') {
            return Response::deny('The Super Admin role cannot be updated');
        }

        return $user->hasRole('Super Admin') ? Response::allow()
            : Response::deny('Only Super Admins can edit roles');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): Response
    {
        if ($role->name == 'Super Admin') {
            return Response::deny('The Super Admin role cannot be deleted');
        }

        return $user->hasRole('Super Admin') ? Response::allow()
            : Response::deny('Only Super Admins can delete roles');
    }
}
