<?php

namespace App\Policies;

use App\Models\User;

class ActivityLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, \App\Models\ActivityLog $record): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, \App\Models\ActivityLog $record): bool
    {
        return false;
    }

    public function delete(User $user, \App\Models\ActivityLog $record): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, \App\Models\ActivityLog $record): bool
    {
        return false;
    }

    public function forceDelete(User $user, \App\Models\ActivityLog $record): bool
    {
        return false;
    }
}
