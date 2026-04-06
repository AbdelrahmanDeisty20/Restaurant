<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Order Information'))
                    ->icon('heroicon-o-shopping-bag')
                    ->description(__('General details and current status of the order.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('order_number')
                            ->disabled()
                            ->label(__('Order Number'))
                            ->icon('heroicon-m-hashtag'),
                        Select::make('user_id')
                            ->relationship('user', 'full_name')
                            ->disabled()
                            ->label(__('Customer Account'))
                            ->icon('heroicon-m-user-circle'),
                        TextInput::make('total_price')
                            ->label(__('Total Price'))
                            ->required()
                            ->numeric()
                            ->prefix('EGP')
                            ->icon('heroicon-m-banknotes'),
                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'pending' => __('Pending'),
                                'accepted' => __('Accepted'),
                                'preparing' => __('Preparing'),
                                'on_the_way' => __('On The Way'),
                                'delivered' => __('Delivered'),
                                'cancelled' => __('Cancelled'),
                            ])
                            ->required()
                            ->native(false)
                            ->icon('heroicon-m-flag'),
                    ]),
                Section::make(__('Delivery & Customer Details'))
                    ->icon('heroicon-o-truck')
                    ->description(__('Identification and shipping information.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('customer_name')
                            ->required()
                            ->label(__('Customer Name'))
                            ->icon('heroicon-m-user'),
                        TextInput::make('customer_phone')
                            ->required()
                            ->label(__('Customer Phone'))
                            ->icon('heroicon-m-phone'),
                        TextInput::make('delivery_address')
                            ->required()
                            ->columnSpanFull()
                            ->label(__('Delivery Address'))
                            ->icon('heroicon-m-map-pin'),
                        Select::make('driver_id')
                            ->relationship('driver', 'name')
                            ->searchable()
                            ->preload()
                            ->label(__('Assign Driver'))
                            ->hint(__('Choose a driver to start tracking'))
                            ->icon('heroicon-m-truck'),
                        TextInput::make('notes')
                            ->label(__('Order Notes'))
                            ->columnSpanFull()
                            ->icon('heroicon-m-document-text'),
                    ]),
            ]);
    }
}
