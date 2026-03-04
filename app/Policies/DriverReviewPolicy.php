<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DriverReview;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverReviewPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DriverReview');
    }

    public function view(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('View:DriverReview');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DriverReview');
    }

    public function update(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('Update:DriverReview');
    }

    public function delete(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('Delete:DriverReview');
    }

    public function restore(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('Restore:DriverReview');
    }

    public function forceDelete(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('ForceDelete:DriverReview');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DriverReview');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DriverReview');
    }

    public function replicate(AuthUser $authUser, DriverReview $driverReview): bool
    {
        return $authUser->can('Replicate:DriverReview');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DriverReview');
    }

}