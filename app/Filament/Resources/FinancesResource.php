<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancesResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Finances;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FinancesResource extends Resource
{
    protected static ?string $model = Finances::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Farm Operations';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'finances';

    public static function canViewAny(): bool
    {
        return ! (bool) (auth()->user()?->isEditor());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(['income' => 'Income', 'expense' => 'Expense'])
                    ->native(false)
                    ->live(),
                Forms\Components\TextInput::make('amount')->required()->numeric()->minValue(0)->prefix('KSh '),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'feeds' => 'Feeds',
                        'medication' => 'Medication',
                        'human_resource' => 'Human resource',
                        'sales' => 'Sales',
                        'dorper' => 'Dorper',
                        'crops' => 'Crops',
                        'rabbits' => 'Rabbits',
                        'other' => 'Other',
                    ])
                    ->native(false)
                    ->live()
                    ->default('other'),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\TextInput::make('description')->maxLength(255),
                Forms\Components\TextInput::make('source')->label('Source / paid to')->maxLength(255),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucfirst($state))),
                Tables\Columns\TextColumn::make('amount')
                    ->money('KES')
                    ->weight('bold')
                    ->color(fn (Finances $record): string => $record->type === 'income' ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')->label('Source / paid to')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('description')->searchable()->placeholder('—')->toggleable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('type')->options(['income' => 'Income', 'expense' => 'Expense']),
                Tables\Filters\SelectFilter::make('category')->options([
                    'feeds' => 'Feeds',
                    'medication' => 'Medication',
                    'human_resource' => 'Human resource',
                    'sales' => 'Sales',
                    'dorper' => 'Dorper',
                    'crops' => 'Crops',
                    'rabbits' => 'Rabbits',
                    'other' => 'Other',
                ]),
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
                Tables\Actions\Action::make('invoice')
                    ->label('Generate invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->fillForm(fn (Finances $record): array => [
                        'amount' => $record->amount,
                        'date' => $record->date,
                        'notes' => $record->description ?: $record->source,
                    ])
                    ->form([
                        Forms\Components\TextInput::make('customer_name')->label('Customer / client')->maxLength(255)->required(),
                        Forms\Components\TextInput::make('amount')->numeric()->minValue(0)->prefix('KSh ')->required(),
                        Forms\Components\DatePicker::make('date')->required()->default(today()),
                        Forms\Components\DatePicker::make('due_date'),
                        Forms\Components\Select::make('status')
                            ->options([
                                Invoice::STATUS_DRAFT => 'Draft',
                                Invoice::STATUS_SENT => 'Sent',
                                Invoice::STATUS_PAID => 'Paid',
                            ])
                            ->default(Invoice::STATUS_DRAFT)
                            ->native(false),
                        Forms\Components\Textarea::make('notes')->rows(2)->maxLength(500),
                    ])
                    ->action(function (Finances $record, array $data): void {
                        $invoice = InvoiceService::createFromFinance($record, $data);

                        Notification::make()
                            ->title('Invoice '.$invoice->invoice_number.' generated')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ManageFinances::route('/'),
        ];
    }
}
