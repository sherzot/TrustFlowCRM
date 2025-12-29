<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $navigationGroup = 'Delivery';

    public static function getModelLabel(): string
    {
        return __('filament.tasks');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.tasks');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.tasks');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.delivery');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->can('view tasks');
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('view tasks');
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('create tasks');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label(__('filament.project'))
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\Select::make('assigned_to')
                    ->label(__('filament.assigned_to'))
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder(__('filament.select_option')),
                Forms\Components\TextInput::make('title')
                    ->label(__('filament.title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.description'))
                    ->rows(3),
                Forms\Components\Select::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'todo' => __('filament.todo'),
                        'in_progress' => __('filament.in_progress'),
                        'review' => __('filament.review'),
                        'done' => __('filament.done'),
                    ])
                    ->default('todo'),
                Forms\Components\Select::make('priority')
                    ->label(__('filament.priority'))
                    ->options([
                        'low' => __('filament.low'),
                        'medium' => __('filament.medium'),
                        'high' => __('filament.high'),
                        'urgent' => __('filament.urgent'),
                    ])
                    ->default('medium'),
                Forms\Components\DatePicker::make('due_date')
                    ->label(__('filament.due_date')),
                Forms\Components\TextInput::make('estimated_hours')
                    ->label(__('filament.estimated_hours'))
                    ->numeric(),
                Forms\Components\TextInput::make('actual_hours')
                    ->label(__('filament.actual_hours'))
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['project', 'assignee', 'tenant'])) // Eager load relationships
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label(__('filament.project'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('assignee.name')
                    ->label(__('filament.assigned_to'))
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(__('filament.status'))
                    ->colors([
                        'secondary' => 'todo',
                        'warning' => 'in_progress',
                        'info' => 'review',
                        'success' => 'done',
                    ]),
                Tables\Columns\BadgeColumn::make('priority')
                    ->label(__('filament.priority'))
                    ->colors([
                        'gray' => 'low',
                        'primary' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ]),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(__('filament.due_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_hours')
                    ->label(__('filament.estimated_hours')),
                Tables\Columns\TextColumn::make('actual_hours')
                    ->label(__('filament.actual_hours')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options([
                        'todo' => __('filament.todo'),
                        'in_progress' => __('filament.in_progress'),
                        'review' => __('filament.review'),
                        'done' => __('filament.done'),
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->label(__('filament.priority'))
                    ->options([
                        'low' => __('filament.low'),
                        'medium' => __('filament.medium'),
                        'high' => __('filament.high'),
                        'urgent' => __('filament.urgent'),
                    ]),
                Tables\Filters\SelectFilter::make('project_id')
                    ->label(__('filament.project'))
                    ->relationship('project', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => Auth::user()->can('edit tasks')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()->can('delete tasks')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->can('delete tasks')),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}

