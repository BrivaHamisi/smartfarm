<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WorkersPolicy extends FarmRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return ! $user->isEditor();
    }

    public function view(User $user, Model $record): bool
    {
        return ! $user->isEditor() && $this->owns($user, $record);
    }

    public function create(User $user): bool
    {
        return ! $user->isEditor();
    }

    public function update(User $user, Model $record): bool
    {
        return ! $user->isEditor() && $this->owns($user, $record);
    }

    public function delete(User $user, Model $record): bool
    {
        return ! $user->isEditor() && $this->owns($user, $record);
    }

    public function deleteAny(User $user): bool
    {
        return ! $user->isEditor();
    }

    public function restore(User $user, Model $record): bool
    {
        return ! $user->isEditor() && $this->owns($user, $record);
    }

    public function forceDelete(User $user, Model $record): bool
    {
        return ! $user->isEditor() && $this->owns($user, $record);
    }
}
