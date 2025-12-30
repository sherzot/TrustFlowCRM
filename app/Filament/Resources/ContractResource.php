<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\DateHelper;
use App\Helpers\PermissionHelper;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Sales';

    public static function getModelLabel(): string
    {
        return __('filament.contract');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.contracts');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.contracts');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.sales');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return PermissionHelper::can('view deals');
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
                Forms\Components\TextInput::make('contract_number')
                    ->label(__('filament.contract_number'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->label(__('filament.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->label(__('filament.content'))
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'draft' => __('filament.draft'),
                        'sent' => __('filament.sent'),
                        'signed' => __('filament.signed'),
                        'cancelled' => __('filament.cancelled'),
                    ])
                    ->default('draft')
                    ->placeholder(__('filament.select_option')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contract_number')
                    ->label(__('filament.contract_number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('account.name')
                    ->label(__('filament.account'))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'secondary' => 'draft',
                        'info' => 'sent',
                        'success' => 'signed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('signed_at')
                    ->label(__('filament.signed_at'))
                    ->formatStateUsing(fn ($state) => DateHelper::formatDateTime($state))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'draft' => __('filament.draft'),
                        'sent' => __('filament.sent'),
                        'signed' => __('filament.signed'),
                        'cancelled' => __('filament.cancelled'),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('send')
                    ->label(__('filament.send'))
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function (Contract $record) {
                        $record->update([
                            'status' => 'sent',
                            'sent_at' => now(),
                        ]);
                    })
                    ->visible(fn (Contract $record) => $record->status === 'draft'),
                Tables\Actions\EditAction::make()
                    ->label(__('filament.edit')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('filament.delete')),
                ])
                ->label(__('filament.actions')),
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
