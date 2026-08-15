<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    /**
     * A record can be managed by an admin, or by a farm owner who manages
     * the editor accounts of their own farm.
     */
    protected function canManage(User $user, User $record): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isOwner()
            && $record->isEditor()
            && (int) $record->farm_owner_id === (int) $user->id;
    }

    public function view(User $user, User $record): bool
    {
        return $this->canManage($user, $record);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    public function update(User $user, User $record): bool
    {
        return $this->canManage($user, $record);
    }

    public function delete(User $user, User $record): bool
    {
        return $this->canManage($user, $record);
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin() || $user->isOwner();
    }

    public function restore(User $user, User $record): bool
    {
        return $this->canManage($user, $record);
    }

    public function forceDelete(User $user, User $record): bool
    {
        return $this->canManage($user, $record);
    }
}
