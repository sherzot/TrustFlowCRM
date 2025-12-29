<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealResource\Pages;
use App\Models\Deal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Domains\Sales\SalesService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DateHelper;
use App\Helpers\PermissionHelper;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationGroup = 'Sales';

    public static function getModelLabel(): string
    {
        return __('filament.deals');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.deals');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.deals');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view deals');
    }

    public static function canViewAny(): bool
    {
        return PermissionHelper::can('view deals');
    }

    public static function canCreate(): bool
    {
        return PermissionHelper::can('create deals');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->label(__('filament.account'))
                    ->relationship('account', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\Select::make('contact_id')
                    ->label(__('filament.contact'))
                    ->relationship('contact', 'first_name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.description'))
                    ->rows(3),
                Forms\Components\TextInput::make('value')
                    ->label(__('filament.value'))
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
                Forms\Components\Select::make('stage')
                    ->label(__('filament.stage'))
                    ->options([
                        'new' => __('filament.new'),
                        'qualified' => __('filament.qualified'),
                        'discovery' => __('filament.discovery'),
                        'proposal' => __('filament.proposal'),
                        'negotiation' => __('filament.negotiation'),
                        'won' => __('filament.won'),
                        'lost' => __('filament.lost'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('probability')
                    ->label(__('filament.probability'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
                Forms\Components\DatePicker::make('expected_close_date')
                    ->label(__('filament.expected_close_date'))
                    ->displayFormat(DateHelper::getDatePickerDisplayFormat())
                    ->format(DateHelper::getDatePickerFormat()),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'open' => __('filament.open'),
                        'won' => __('filament.won'),
                        'lost' => __('filament.lost'),
                    ])
                    ->default('open'),
                Forms\Components\TextInput::make('ai_score')
                    ->label(__('filament.ai_score'))
                    ->numeric()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['account', 'contact', 'tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label(__('filament.account'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('stage')
                    ->label(__('filament.stage'))
                    ->badge()
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'qualified',
                        'info' => 'discovery',
                        'success' => 'won',
                        'danger' => 'lost',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('filament.value'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('probability')
                    ->label(__('filament.probability'))
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ai_score')
                    ->label(__('filament.ai_score'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_close_date')
                    ->label(__('filament.expected_close_date'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDate($state))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage')
                    ->label(__('filament.stage'))
                    ->options([
                        'new' => __('filament.new'),
                        'qualified' => __('filament.qualified'),
                        'discovery' => __('filament.discovery'),
                        'proposal' => __('filament.proposal'),
                        'negotiation' => __('filament.negotiation'),
                        'won' => __('filament.won'),
                        'lost' => __('filament.lost'),
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'open' => __('filament.open'),
                        'won' => __('filament.won'),
                        'lost' => __('filament.lost'),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('win')
                    ->label(__('filament.win'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => PermissionHelper::can('edit deals'))
                    ->action(function (Deal $record) {
                        $salesService = app(SalesService::class);
                        $salesService->winDeal($record);
                    }),
                Tables\Actions\Action::make('lose')
                    ->label(__('filament.lose'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => PermissionHelper::can('edit deals'))
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label(__('filament.lost_reason'))
                            ->required(),
                    ])
                    ->action(function (Deal $record, array $data) {
                        $salesService = app(SalesService::class);
                        $salesService->loseDeal($record, $data['reason']);
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => PermissionHelper::can('edit deals')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => PermissionHelper::can('delete deals')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeals::route('/'),
            'create' => Pages\CreateDeal::route('/create'),
            'edit' => Pages\EditDeal::route('/{record}/edit'),
        ];
    }
}

