<?php

namespace App\Filament\Resources\FinancesResource\Pages;

use App\Filament\Resources\FinancesResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFinances extends ManageRecords
{
    protected static string $resource = FinancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
