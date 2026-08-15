<?php

namespace App\Filament\Resources\DorperAnimalResource\Pages;

use App\Filament\Resources\DorperAnimalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDorperAnimals extends ManageRecords
{
    protected static string $resource = DorperAnimalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
