<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;
use App\Helpers\DateHelper;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Sales';

    public static function getModelLabel(): string
    {
        return __('filament.accounts');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.accounts');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.accounts');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view accounts');
    }

    public static function canViewAny(): bool
    {
        return PermissionHelper::can('view accounts');
    }

    public static function canCreate(): bool
    {
        return PermissionHelper::can('create accounts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('industry')
                    ->label(__('filament.industry'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->label(__('filament.website'))
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('filament.phone'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('filament.email'))
                    ->email()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label(__('filament.address'))
                    ->rows(3),
                Forms\Components\TextInput::make('city')
                    ->label(__('filament.city'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->label(__('filament.state'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->label(__('filament.country'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal_code')
                    ->label(__('filament.postal_code'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('annual_revenue')
                    ->label(__('filament.annual_revenue'))
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('employee_count')
                    ->label(__('filament.employee_count'))
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'active' => __('filament.active'),
                        'inactive' => __('filament.inactive'),
                    ])
                    ->default('active'),
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('industry')
                    ->label(__('filament.industry'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament.phone')),
                Tables\Columns\TextColumn::make('ai_score')
                    ->label(__('filament.ai_score'))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.created_at'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDateTime($state))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'active' => __('filament.active'),
                        'inactive' => __('filament.inactive'),
                    ]),
                Tables\Filters\SelectFilter::make('industry')
                    ->label(__('filament.industry')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->can('delete accounts')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}

