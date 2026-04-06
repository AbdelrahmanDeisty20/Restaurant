<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Promotional Product'))
                    ->icon('heroicon-o-shopping-bag')
                    ->description(__('Select the product this offer applies to.'))
                    ->schema([
                        Select::make('product_id')
                            ->label(__('Product'))
                            ->relationship('product', "name_" . app()->getLocale())
                            ->searchable()
                            ->preload()
                            ->required()
                            ->icon('heroicon-m-cube'),
                    ]),

                Section::make(__('Discount Rules'))
                    ->icon('heroicon-o-gift')
                    ->description(__('Set the discount intensity.'))
                    ->schema([
                        TextInput::make('discount_percentage')
                            ->label(__('Discount Percentage'))
                            ->required()
                            ->numeric()
                            ->prefix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->icon('heroicon-m-receipt-percent'),
                    ]),

                Section::make(__('Campaign Timeline'))
                    ->icon('heroicon-o-calendar-days')
                    ->description(__('Set the active dates for this promotional offer.'))
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->label(__('Start Date'))
                            ->icon('heroicon-m-calendar-days'),
                        DateTimePicker::make('end_date')
                            ->label(__('End Date'))
                            ->icon('heroicon-m-calendar-days'),
                    ]),

                Section::make(__('Offer Status'))
                    ->icon('heroicon-o-power')
                    ->description(__('Enable or disable this campaign.') )
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required()
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}