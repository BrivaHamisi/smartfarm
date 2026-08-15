<?php

namespace App\Filament\Widgets\Concerns;

trait AppliesPageFilters
{
    protected function resolveFarmId(): ?int
    {
        $user = auth()->user();

        if ($user && ! $user->isAdmin()) {
            return (int) $user->farmId();
        }

        return $this->filters['farm_id'] ?? null;
    }

    protected function filterFrom(): ?string
    {
        return $this->filters['from'] ?? null;
    }

    protected function filterUntil(): ?string
    {
        return $this->filters['until'] ?? null;
    }
}
