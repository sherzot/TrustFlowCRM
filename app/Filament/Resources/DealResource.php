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

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->relationship('account', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'first_name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(3),
                Forms\Components\TextInput::make('value')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                Forms\Components\Select::make('currency')
                    ->options([
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ])
                    ->default('USD'),
                Forms\Components\Select::make('stage')
                    ->options([
                        'new' => 'New',
                        'qualified' => 'Qualified',
                        'discovery' => 'Discovery & Proposal',
                        'proposal' => 'Proposal',
                        'negotiation' => 'Negotiation',
                        'won' => 'Won',
                        'lost' => 'Lost',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('probability')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
                Forms\Components\DatePicker::make('expected_close_date'),
                Forms\Components\Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'won' => 'Won',
                        'lost' => 'Lost',
                    ])
                    ->default('open'),
                Forms\Components\TextInput::make('ai_score')
                    ->numeric()
                    ->disabled()
                    ->label('AI Score'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stage')
                    ->badge()
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'qualified',
                        'info' => 'discovery',
                        'success' => 'won',
                        'danger' => 'lost',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('probability')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ai_score')
                    ->label('AI Score')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_close_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage'),
                Tables\Filters\SelectFilter::make('status'),
            ])
            ->actions([
                Tables\Actions\Action::make('win')
                    ->label('Win')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Deal $record) {
                        $salesService = app(SalesService::class);
                        $salesService->winDeal($record);
                    }),
                Tables\Actions\Action::make('lose')
                    ->label('Lose')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Lost Reason')
                            ->required(),
                    ])
                    ->action(function (Deal $record, array $data) {
                        $salesService = app(SalesService::class);
                        $salesService->loseDeal($record, $data['reason']);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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

