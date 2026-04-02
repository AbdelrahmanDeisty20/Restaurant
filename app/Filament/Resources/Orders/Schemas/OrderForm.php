<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Order Information'))
                    ->columns(2)
                    ->components([
                        TextInput::make('order_number')
                            ->disabled()
                            ->label(__('Order Number')),
                        Select::make('user_id')
                            ->relationship('user', 'full_name')
                            ->disabled()
                            ->label(__('Customer')),
                        TextInput::make('total_price')
                            ->label(__('Total Price'))
                            ->required()
                            ->numeric()
                            ->prefix('$'),
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
                            ->native(false),
                    ]),
                Section::make(__('Delivery Details'))
                    ->columns(2)
                    ->components([
                        TextInput::make('customer_name')
                            ->required()
                            ->label(__('Customer Name')),
                        TextInput::make('customer_phone')
                            ->required()
                            ->label(__('Customer Phone')),
                        TextInput::make('delivery_address')
                            ->required()
                            ->columnSpanFull()
                            ->label(__('Delivery Address')),
                        Select::make('driver_id')
                            ->relationship('driver', 'name')
                            ->searchable()
                            ->preload()
                            ->label(__('Assign Driver'))
                            ->hint(__('Choose a driver to start tracking')),
                        TextInput::make('notes')
                            ->label(__('Order Notes'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
