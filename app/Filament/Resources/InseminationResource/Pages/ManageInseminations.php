<?php

namespace App\Filament\Resources\InseminationResource\Pages;

use App\Filament\Resources\InseminationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInseminations extends ManageRecords
{
    protected static string $resource = InseminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
