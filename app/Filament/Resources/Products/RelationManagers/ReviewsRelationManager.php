<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'productReviews';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Reviews');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.full_name')
                    ->label(__('User'))
                    ->disabled(),
                TextInput::make('rating')
                    ->label(__('Rating'))
                    ->numeric()
                    ->required(),
                TextInput::make('comment')
                    ->label(__('Comment'))
                    ->maxLength(1000),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.full_name')
            ->columns([
                TextColumn::make('user.full_name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => $record->orderReview?->user ? \App\Filament\Resources\Users\UserResource::getUrl('view', ['record' => $record->orderReview->user]) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('rating')
                    ->label(__('Rating'))
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->limit(50)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->recordActions([

            ])
            ->toolbarActions([

            ]);
    }
}