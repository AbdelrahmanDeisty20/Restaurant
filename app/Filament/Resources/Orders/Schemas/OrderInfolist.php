<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Order Information'))
                    ->icon('heroicon-o-shopping-bag')
                    ->description(__('General summary and status of the order.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label(__('Order Number'))
                                    ->icon('heroicon-m-hashtag')
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('total_price')
                                    ->label(__('Total Price'))
                                    ->money('EGP')
                                    ->icon('heroicon-m-banknotes')
                                    ->color('success')
                                    ->weight('bold'),
                                TextEntry::make('status')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'accepted', 'preparing', 'on_the_way' => 'info',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state): string => __($state)),
                            ]),
                    ]),

                Section::make(__('Customer & Delivery Information'))
                    ->icon('heroicon-o-truck')
                    ->description(__('Who placed the order and where it should go.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('user.full_name') // Using relationship
                                    ->label(__('Account User'))
                                    ->icon('heroicon-m-user-circle')
                                    ->default(__('Guest')),
                                TextEntry::make('customer_name') // Using specific order field
                                    ->label(__('Customer Name'))
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('customer_phone')
                                    ->label(__('Customer Phone'))
                                    ->icon('heroicon-m-phone')
                                    ->copyable(),
                            ]),
                        TextEntry::make('delivery_address')
                            ->label(__('Delivery Address'))
                            ->icon('heroicon-m-map-pin')
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Additional Details'))
                    ->icon('heroicon-o-information-circle')
                    ->collapsed() // Keep it clean
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('notes')
                                    ->label(__('Order Notes'))
                                    ->placeholder(__('No special notes provided.')),
                                TextEntry::make('created_at')
                                    ->label(__('Order Date'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar'),
                            ]),
                    ]),
            ]);
    }
}
