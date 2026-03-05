<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExtrasRelationManager extends RelationManager
{
    protected static string $relationship = 'extras';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Extras');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Name AR'))
                    ->required(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->required(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->required()
                    ->numeric()
                    ->prefix('EGP'),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'size' => __('Size'),
                        'extra' => __('Extra'),
                    ])
                    ->required()
                    ->default('size'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(['name_ar', 'name_en']),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'size' => 'info',
                        'extra' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state === 'size' ? 'Size' : 'Extra')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->multiple()
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
