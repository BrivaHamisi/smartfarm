<?php

namespace App\Filament\Resources\MilkProductionResource\Pages;

use App\Filament\Resources\MilkProductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMilkRecords extends ManageRecords
{
    protected static string $resource = MilkProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
