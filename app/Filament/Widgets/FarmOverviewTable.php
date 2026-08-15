<?php

namespace App\Filament\Widgets;

use App\Models\Calf;
use App\Models\Cattle;
use App\Models\Checkup;
use App\Models\CropField;
use App\Models\CropHarvest;
use App\Models\CropInput;
use App\Models\DorperAnimal;
use App\Models\DorperBreedingRecord;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\MilkProduction;
use App\Models\Poultry;
use App\Models\Rabbit;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Models\Workers;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class FarmOverviewTable extends TableWidget
{
    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        return (bool) (auth()->user()?->is_admin);
    }

    protected function getTableHeading(): string
    {
        return 'Farm owners';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->orderBy('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('name')->weight('bold'),
                Tables\Columns\TextColumn::make('email')->limit(22)->color('gray'),
                Tables\Columns\TextColumn::make('records')
                    ->label('Records')
                    ->state(fn (User $record): int => array_sum([
                        Cattle::query()->where('user_id', $record->id)->count(),
                        Calf::query()->where('user_id', $record->id)->count(),
                        MilkProduction::query()->where('user_id', $record->id)->count(),
                        Insemination::query()->where('user_id', $record->id)->count(),
                        Checkup::query()->where('user_id', $record->id)->count(),
                        Poultry::query()->where('user_id', $record->id)->count(),
                        Finances::query()->where('user_id', $record->id)->count(),
                        Workers::query()->where('user_id', $record->id)->count(),
                        DorperAnimal::query()->where('user_id', $record->id)->count(),
                        DorperBreedingRecord::query()->where('user_id', $record->id)->count(),
                        CropField::query()->where('user_id', $record->id)->count(),
                        CropInput::query()->where('user_id', $record->id)->count(),
                        CropHarvest::query()->where('user_id', $record->id)->count(),
                        Rabbit::query()->where('user_id', $record->id)->count(),
                        RabbitBreedingRecord::query()->where('user_id', $record->id)->count(),
                    ]))
                    ->badge()
                    ->color('primary')
                    ->alignEnd(),
                Tables\Columns\IconColumn::make('is_admin')->label('Admin')->boolean()->toggleable(),
            ])
            ->paginated(false)
            ->defaultPaginationPageOption(5);
    }
}
