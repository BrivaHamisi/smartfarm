<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, User $record): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, User $record): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, User $record): bool
    {
        return $user->is_admin;
    }

    public function deleteAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, User $record): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, User $record): bool
    {
        return $user->is_admin;
    }
}
