<?php

namespace App\Filament\Resources\CropHarvestResource\Pages;

use App\Filament\Resources\CropHarvestResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCropHarvests extends ManageRecords
{
    protected static string $resource = CropHarvestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
