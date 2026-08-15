<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class FarmRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Model $record): bool
    {
        return $this->owns($user, $record);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Model $record): bool
    {
        return $this->owns($user, $record);
    }

    public function delete(User $user, Model $record): bool
    {
        return $this->owns($user, $record);
    }

    public function deleteAny(User $user): bool
    {
        return true;
    }

    public function restore(User $user, Model $record): bool
    {
        return $this->owns($user, $record);
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return $this->owns($user, $record);
    }

    protected function owns(User $user, Model $record): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return (int) $record->user_id === (int) ($user->farmId() ?? $user->id);
    }
}
