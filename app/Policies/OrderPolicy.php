<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->hasRole(['super_admin', 'admin']);
    }

    public function view(AuthUser $authUser, Order $order): bool
    {
        return $authUser->hasRole(['super_admin', 'admin']) || $authUser->id === $order->user_id;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Order');
    }

    public function update(AuthUser $authUser, Order $order): bool
    {
        // Admin can update status. Customer cannot update once created.
        return $authUser->hasRole(['super_admin', 'admin']);
    }

    public function delete(AuthUser $authUser, Order $order): bool
    {
        // Orders should generally not be deleted.
        return false;
    }

    public function restore(AuthUser $authUser, Order $order): bool
    {
        return $authUser->can('Restore:Order');
    }

    public function forceDelete(AuthUser $authUser, Order $order): bool
    {
        return $authUser->can('ForceDelete:Order');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Order');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Order');
    }

    public function replicate(AuthUser $authUser, Order $order): bool
    {
        return $authUser->can('Replicate:Order');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Order');
    }
}
