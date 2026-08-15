<?php

namespace App\Filament\Resources\CheckupResource\Pages;

use App\Filament\Resources\CheckupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCheckups extends ManageRecords
{
    protected static string $resource = CheckupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
