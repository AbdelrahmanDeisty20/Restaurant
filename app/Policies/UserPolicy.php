<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['super_admin', 'admin']);
    }

    public function view(AuthUser $authUser, \App\Models\User $user): bool
    {
        return $authUser->hasRole(['super_admin', 'admin']) || $authUser->id === $user->id;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    public function update(AuthUser $authUser, \App\Models\User $user): bool
    {
        // Admin can update status (handled in Form), but generally can only update own record info.
        return $authUser->hasRole('super_admin') || ($authUser->hasRole('admin') && $user->id !== $authUser->id) || $authUser->id === $user->id;
    }

    public function delete(AuthUser $authUser, \App\Models\User $user): bool
    {
        return $authUser->hasRole('super_admin') && $authUser->id !== $user->id;
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:User');
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }
}
