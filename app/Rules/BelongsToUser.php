<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BelongsToUser implements ValidationRule
{
    public function __construct(protected string $modelClass, protected ?string $key = null)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth()->user();

        if ($user?->is_admin || blank($value)) {
            return;
        }

        $record = ($this->modelClass)::query()
            ->where($this->key ?? 'id', $value)
            ->first();

        if (! $record) {
            $fail('The selected :attribute is invalid.');

            return;
        }

        $ownerId = session('farm_owner_id', $user?->id);

        if ((int) $record->user_id !== (int) $ownerId) {
            $fail('The selected :attribute is invalid.');
        }
    }
}
