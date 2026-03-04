<?php

namespace App\Filament\Resources\Drivers\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriverReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'driverReviews';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('orderReview.user.full_name')
                    ->label(__('User'))
                    ->sortable()
                    ->url(fn($record) => $record->orderReview?->user ? \App\Filament\Resources\Users\UserResource::getUrl('view', ['record' => $record->orderReview->user]) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('rating')
                    ->label(__('Rating'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Reviews are generated from orders, so we don't usually create them manually here
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
