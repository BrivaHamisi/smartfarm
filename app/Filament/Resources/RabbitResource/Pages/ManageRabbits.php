<?php

namespace App\Filament\Resources\RabbitResource\Pages;

use App\Filament\Resources\RabbitResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRabbits extends ManageRecords
{
    protected static string $resource = RabbitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
