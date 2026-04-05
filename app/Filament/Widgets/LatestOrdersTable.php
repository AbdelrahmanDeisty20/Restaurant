<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrdersTable extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label(__('Order Number'))
                    ->searchable(),
                TextColumn::make('customer')
                    ->label(__('Customer'))
                    ->state(fn(Order $record): string => $record->user?->full_name ?? $record->customer_name ?? __('Guest')),
                TextColumn::make('total_price')
                    ->label(__('Total Price'))
                    ->money('EGP'),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing', 'preparing' => 'info',
                        'on_the_way' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->since(),
            ])
            ->actions([
                Action::make('view')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ]);
    }
}
