<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * Perform a preliminary check before any other authorization methods.
     *
     * This method allows a "Super Admin" to bypass other checks when the application
     * is not in production mode.
     */
    public function before(User $user, string $ability): ?bool
    {
        if (! app()->isProduction() && $user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasPermissionTo('view all permissions')
            ? Response::allow()
            : Response::deny('You do not have permission to view roles');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::deny('Only Super Admins can create any permissions');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): Response
    {
        return Response::deny('Only Super Admins can edit permissions');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): Response
    {
        return Response::deny('Only Super Admins can delete permissions');
    }
}
