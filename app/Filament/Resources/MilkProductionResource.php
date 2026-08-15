<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MilkProductionResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Cattle;
use App\Models\MilkProduction;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MilkProductionResource extends Resource
{
    protected static ?string $model = MilkProduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Livestock';

    protected static ?string $slug = 'milk-records';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'milk record';

    protected static ?string $pluralModelLabel = 'milk records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\Select::make('cow_id')
                    ->label('Cow')
                    ->relationship('cow', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([new BelongsToUser(Cattle::class)]),
                Forms\Components\TextInput::make('morning')->required()->numeric()->minValue(0)->suffix(' L'),
                Forms\Components\TextInput::make('afternoon')->required()->numeric()->minValue(0)->suffix(' L'),
                Forms\Components\TextInput::make('evening')->required()->numeric()->minValue(0)->suffix(' L'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('cow.name')->label('Cow')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('morning')->numeric(2)->suffix(' L')->toggleable()->color('info'),
                Tables\Columns\TextColumn::make('afternoon')->numeric(2)->suffix(' L')->toggleable()->color('warning'),
                Tables\Columns\TextColumn::make('evening')->numeric(2)->suffix(' L')->toggleable()->color('gray'),
                Tables\Columns\TextColumn::make('total_yield')
                    ->label('Total')
                    ->numeric(2)
                    ->suffix(' L')
                    ->weight('bold'),
                OwnerColumn::make(),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('cow_id')
                    ->label('Cow')
                    ->relationship('cow', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Table $table, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $table->getQuery()
                            ->when($data['from'], fn ($query, $date) => $query->whereDate('date', '>=', $date))
                            ->when($data['until'], fn ($query, $date) => $query->whereDate('date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMilkRecords::route('/'),
        ];
    }
}
