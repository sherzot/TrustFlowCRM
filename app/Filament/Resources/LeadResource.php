<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Domains\Sales\SalesService;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('source')
                    ->options([
                        'website' => 'Website',
                        'referral' => 'Referral',
                        'social' => 'Social Media',
                        'email' => 'Email Campaign',
                        'other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company')
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('industry')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'qualified' => 'Qualified',
                        'converted' => 'Converted',
                    ])
                    ->default('new'),
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
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('source')
                    ->badge(),
                Tables\Columns\TextColumn::make('ai_score')
                    ->label('AI Score')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'contacted',
                        'success' => 'qualified',
                        'info' => 'converted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\SelectFilter::make('source'),
            ])
            ->actions([
                Tables\Actions\Action::make('convert')
                    ->label('Convert')
                    ->icon('heroicon-o-arrow-right')
                    ->requiresConfirmation()
                    ->action(function (Lead $record) {
                        $salesService = app(SalesService::class);
                        $salesService->convertLead($record);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}

