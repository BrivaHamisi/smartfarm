<?php

namespace App\Filament\Resources\CropInputResource\Pages;

use App\Filament\Resources\CropInputResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCropInputs extends ManageRecords
{
    protected static string $resource = CropInputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
