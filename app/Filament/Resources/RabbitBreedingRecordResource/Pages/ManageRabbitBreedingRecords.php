<?php

namespace App\Filament\Resources\RabbitBreedingRecordResource\Pages;

use App\Filament\Resources\RabbitBreedingRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRabbitBreedingRecords extends ManageRecords
{
    protected static string $resource = RabbitBreedingRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
