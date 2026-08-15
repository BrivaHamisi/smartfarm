<?php

namespace App\Filament\Resources\DorperBreedingRecordResource\Pages;

use App\Filament\Resources\DorperBreedingRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDorperBreedingRecords extends ManageRecords
{
    protected static string $resource = DorperBreedingRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
