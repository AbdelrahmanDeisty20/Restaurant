<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProductExtra;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductExtraPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductExtra');
    }

    public function view(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('View:ProductExtra');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductExtra');
    }

    public function update(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('Update:ProductExtra');
    }

    public function delete(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('Delete:ProductExtra');
    }

    public function restore(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('Restore:ProductExtra');
    }

    public function forceDelete(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('ForceDelete:ProductExtra');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductExtra');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductExtra');
    }

    public function replicate(AuthUser $authUser, ProductExtra $productExtra): bool
    {
        return $authUser->can('Replicate:ProductExtra');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductExtra');
    }

}