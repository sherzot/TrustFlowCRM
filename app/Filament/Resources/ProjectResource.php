<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Delivery';

    public static function getModelLabel(): string
    {
        return __('filament.projects');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.projects');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.projects');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.delivery');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->can('view projects');
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view projects');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create projects');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('deal_id')
                    ->label(__('filament.deal'))
                    ->relationship('deal', 'name')
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
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.description'))
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'planning' => __('filament.planning'),
                        'active' => __('filament.active'),
                        'on_hold' => __('filament.on_hold'),
                        'completed' => __('filament.completed'),
                        'cancelled' => __('filament.cancelled'),
                    ])
                    ->default('planning'),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('filament.start_date')),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('filament.end_date')),
                Forms\Components\TextInput::make('budget')
                    ->label(__('filament.budget'))
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('currency')
                    ->label(__('filament.currency'))
                    ->options([
                        'USD' => 'USD',
                        'EUR' => 'EUR',
                        'GBP' => 'GBP',
                    ])
                    ->default('USD'),
                Forms\Components\TextInput::make('progress')
                    ->label(__('filament.progress'))
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['account', 'deal', 'tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label(__('filament.account'))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'warning' => 'planning',
                        'success' => 'active',
                        'info' => 'on_hold',
                        'primary' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('budget')
                    ->label(__('filament.budget'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_cost')
                    ->label(__('filament.actual_cost'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('profit')
                    ->label(__('filament.profit'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('progress')
                    ->label(__('filament.progress'))
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('filament.start_date'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'planning' => __('filament.planning'),
                        'active' => __('filament.active'),
                        'on_hold' => __('filament.on_hold'),
                        'completed' => __('filament.completed'),
                        'cancelled' => __('filament.cancelled'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => Auth::user()->can('edit projects')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()->can('delete projects')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->can('delete projects')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}

