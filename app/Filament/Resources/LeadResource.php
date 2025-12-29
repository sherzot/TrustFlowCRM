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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;
use App\Helpers\DateHelper;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = 'Sales';

    public static function getModelLabel(): string
    {
        return __('filament.leads');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.leads');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.leads');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view leads');
    }

    public static function canViewAny(): bool
    {
        return PermissionHelper::can('view leads');
    }

    public static function canCreate(): bool
    {
        return PermissionHelper::can('create leads');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('source')
                    ->label(__('filament.source'))
                    ->options([
                        'website' => __('filament.website'),
                        'referral' => __('filament.referral'),
                        'social' => __('filament.social_media'),
                        'email' => __('filament.email_campaign'),
                        'other' => __('filament.other'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->label(__('filament.first_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label(__('filament.last_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('filament.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('filament.phone'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company')
                    ->label(__('filament.company'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->label(__('filament.title'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->label(__('filament.website'))
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('industry')
                    ->label(__('filament.industry'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.description'))
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'new' => __('filament.new'),
                        'contacted' => __('filament.contacted'),
                        'qualified' => __('filament.qualified'),
                        'converted' => __('filament.converted'),
                    ])
                    ->default('new'),
                Forms\Components\TextInput::make('ai_score')
                    ->label(__('filament.ai_score'))
                    ->numeric()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('filament.first_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('filament.last_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('company')
                    ->label(__('filament.company'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('source')
                    ->label(__('filament.source'))
                    ->badge(),
                Tables\Columns\TextColumn::make('ai_score')
                    ->label(__('filament.ai_score'))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'primary' => 'new',
                        'warning' => 'contacted',
                        'success' => 'qualified',
                        'info' => 'converted',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDateTime($state))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'new' => __('filament.new'),
                        'contacted' => __('filament.contacted'),
                        'qualified' => __('filament.qualified'),
                        'converted' => __('filament.converted'),
                    ]),
                Tables\Filters\SelectFilter::make('source')
                    ->label(__('filament.source')),
            ])
            ->actions([
                Tables\Actions\Action::make('convert')
                    ->label(__('filament.convert'))
                    ->icon('heroicon-o-arrow-right')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => PermissionHelper::can('edit leads'))
                    ->action(function (Lead $record) {
                        $salesService = app(SalesService::class);
                        $salesService->convertLead($record);
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => PermissionHelper::can('edit leads')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => PermissionHelper::can('delete leads')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => PermissionHelper::can('delete leads')),
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

