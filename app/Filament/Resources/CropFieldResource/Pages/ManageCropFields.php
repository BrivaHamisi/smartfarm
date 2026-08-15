<?php

namespace App\Filament\Resources\CropFieldResource\Pages;

use App\Filament\Resources\CropFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCropFields extends ManageRecords
{
    protected static string $resource = CropFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
