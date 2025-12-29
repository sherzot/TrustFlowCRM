<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DateHelper;
use App\Helpers\PermissionHelper;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Finance';

    public static function getModelLabel(): string
    {
        return __('filament.invoices');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.invoices');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.invoices');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.finance');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view invoices');
    }

    public static function canViewAny(): bool
    {
        return PermissionHelper::can('view invoices');
    }

    public static function canCreate(): bool
    {
        return PermissionHelper::can('create invoices');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label(__('filament.project'))
                    ->relationship('project', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\Select::make('account_id')
                    ->label(__('filament.account'))
                    ->relationship('account', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\TextInput::make('invoice_number')
                    ->label(__('filament.invoice_number'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('issue_date')
                    ->label(__('filament.issue_date'))
                    ->required()
                    ->default(now())
                    ->displayFormat(DateHelper::getDatePickerDisplayFormat())
                    ->format(DateHelper::getDatePickerFormat()),
                Forms\Components\DatePicker::make('due_date')
                    ->label(__('filament.due_date'))
                    ->required()
                    ->displayFormat(DateHelper::getDatePickerDisplayFormat())
                    ->format(DateHelper::getDatePickerFormat()),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'draft' => __('filament.draft'),
                        'sent' => __('filament.sent'),
                        'paid' => __('filament.paid'),
                        'overdue' => __('filament.overdue'),
                        'cancelled' => __('filament.cancelled'),
                    ])
                    ->default('draft'),
                Forms\Components\TextInput::make('subtotal')
                    ->label(__('filament.subtotal'))
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                Forms\Components\TextInput::make('tax_rate')
                    ->label(__('filament.tax_rate'))
                    ->numeric()
                    ->suffix('%')
                    ->default(0),
                Forms\Components\TextInput::make('tax_amount')
                    ->label(__('filament.tax_amount'))
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('total')
                    ->label(__('filament.total'))
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                Forms\Components\Select::make('currency')
                    ->label(__('filament.currency'))
                    ->options([
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ])
                    ->default('USD'),
                Forms\Components\Textarea::make('notes')
                    ->label(__('filament.notes'))
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['account', 'project', 'tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label(__('filament.invoice_number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label(__('filament.account'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->label(__('filament.issue_date'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDate($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('filament.due_date'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDate($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label(__('filament.total'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'secondary' => 'draft',
                        'info' => 'sent',
                        'success' => 'paid',
                        'danger' => 'overdue',
                        'gray' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label(__('filament.paid_at'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDateTime($state))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'draft' => __('filament.draft'),
                        'sent' => __('filament.sent'),
                        'paid' => __('filament.paid'),
                        'overdue' => __('filament.overdue'),
                        'cancelled' => __('filament.cancelled'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => Auth::user()->can('edit invoices')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()->can('delete invoices')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->can('delete invoices')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}

