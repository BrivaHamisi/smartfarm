<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Finances;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Finance & Reports';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'invoices';

    protected static ?string $modelLabel = 'invoice';

    public static function canViewAny(): bool
    {
        return ! (bool) (auth()->user()?->isEditor());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('finance_id')
                    ->label('Linked transaction')
                    ->options(fn (): array => Finances::query()
                        ->orderByDesc('date')
                        ->get()
                        ->mapWithKeys(fn (Finances $finance): array => [
                            $finance->id => '#'.$finance->id.' · '.ucfirst($finance->type).' · KSh '.number_format($finance->amount).' · '.$finance->date->format('d M Y'),
                        ])
                        ->all())
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('customer_name')->label('Customer / client')->maxLength(255),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\DatePicker::make('due_date'),
                Forms\Components\TextInput::make('amount')->required()->numeric()->minValue(0)->prefix('KSh '),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        Invoice::STATUS_DRAFT => 'Draft',
                        Invoice::STATUS_SENT => 'Sent',
                        Invoice::STATUS_PAID => 'Paid',
                    ])
                    ->default(Invoice::STATUS_DRAFT)
                    ->native(false),
                Forms\Components\Textarea::make('notes')->rows(2)->maxLength(500),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')->searchable()->weight('bold')->description(fn (Invoice $record): ?string => $record->customer_name ?: null),
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Customer / client')->searchable()->placeholder('—'),
                Tables\Columns\TextColumn::make('amount')->money('KES')->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Invoice::STATUS_PAID => 'success',
                        Invoice::STATUS_SENT => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('finance_id')
                    ->label('Source')
                    ->formatStateUsing(fn (?int $state): string => $state ? '#' . $state : '—')
                    ->placeholder('—')
                    ->alignCenter(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('status')->options([
                    Invoice::STATUS_DRAFT => 'Draft',
                    Invoice::STATUS_SENT => 'Sent',
                    Invoice::STATUS_PAID => 'Paid',
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
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Invoice $record): string => route('pdf.invoice', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('mark_paid')
                    ->label('Mark paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Invoice $record): bool => ! $record->isPaid())
                    ->requiresConfirmation()
                    ->action(function (Invoice $record): void {
                        $record->update(['status' => Invoice::STATUS_PAID]);

                        Notification::make()->title('Invoice marked as paid')->success()->send();
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
            'index' => Pages\ManageInvoices::route('/'),
        ];
    }
}
