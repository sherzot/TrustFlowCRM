<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Sales';

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function getModelLabel(): string
    {
        return __('filament.contacts');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.contacts');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.contacts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->label(__('filament.account'))
                    ->relationship('account', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
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
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(__('filament.phone'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->label(__('filament.mobile'))
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->label(__('filament.title'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->label(__('filament.department'))
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_primary')
                    ->label(__('filament.is_primary'))
                    ->default(false),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'active' => __('filament.active'),
                        'inactive' => __('filament.inactive'),
                    ])
                    ->default('active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['account', 'tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label(__('filament.first_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label(__('filament.last_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label(__('filament.account'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament.phone')),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.title')),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label(__('filament.is_primary'))
                    ->boolean(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'active' => __('filament.active'),
                        'inactive' => __('filament.inactive'),
                    ]),
                Tables\Filters\SelectFilter::make('account_id')
                    ->label(__('filament.account'))
                    ->relationship('account', 'name'),
            ])
            ->actions([
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}

