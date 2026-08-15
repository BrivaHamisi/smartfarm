<?php

namespace App\Filament\Resources\PoultryResource\Pages;

use App\Filament\Resources\PoultryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePoultryRecords extends ManageRecords
{
    protected static string $resource = PoultryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
