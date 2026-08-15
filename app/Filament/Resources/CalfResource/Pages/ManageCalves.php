<?php

namespace App\Filament\Resources\CalfResource\Pages;

use App\Filament\Resources\CalfResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCalves extends ManageRecords
{
    protected static string $resource = CalfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
