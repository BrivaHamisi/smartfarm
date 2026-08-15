<?php

namespace App\Filament\Resources\WorkersResource\Pages;

use App\Filament\Resources\WorkersResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkers extends ManageRecords
{
    protected static string $resource = WorkersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
