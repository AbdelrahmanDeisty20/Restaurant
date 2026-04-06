<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label(__('Order Number'))
                    ->icon('heroicon-m-hashtag')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.full_name') // Relationship name
                    ->label(__('Account User'))
                    ->icon('heroicon-m-user-circle')
                    ->default(__('Guest'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name') // Specific order field
                    ->label(__('Customer Name'))
                    ->icon('heroicon-m-user')
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label(__('Total Price'))
                    ->money('EGP')
                    ->color('success')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted', 'preparing', 'on_the_way' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
