<?php

namespace App\Filament\Resources\CattleResource\Pages;

use App\Filament\Resources\CattleResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCattle extends ManageRecords
{
    protected static string $resource = CattleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
