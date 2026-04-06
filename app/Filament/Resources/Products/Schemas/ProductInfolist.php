<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('General Content'))
                    ->icon('heroicon-o-cube')
                    ->description(__('Identification and category details of the product.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('name_en')
                                    ->label(__('Name EN'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('category.name')
                                    ->label(__('Category'))
                                    ->icon('heroicon-m-tag')
                                    ->color('primary')
                                    ->badge(),
                            ]),
                        TextEntry::make('description_ar')
                            ->label(__('Description AR'))
                            ->prose()
                            ->columnSpanFull(),
                        TextEntry::make('description_en')
                            ->label(__('Description EN'))
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Visual Assets'))
                    ->icon('heroicon-o-photo')
                    ->description(__('The primary image representing the product.'))
                    ->schema([
                        ImageEntry::make('main_image')
                            ->label(__('Main Image'))
                            ->disk('public')
                            ->circular()
                            ->size(200),
                    ]),

                Section::make(__('Pricing & Status'))
                    ->icon('heroicon-o-currency-dollar')
                    ->description(__('Financial details and availability toggles.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('price')
                                    ->label(__('Price'))
                                    ->money('EGP')
                                    ->icon('heroicon-m-banknotes')
                                    ->color('success')
                                    ->weight('bold'),
                                TextEntry::make('discount_price')
                                    ->label(__('Discount Price'))
                                    ->money('EGP')
                                    ->icon('heroicon-m-receipt-percent')
                                    ->color('danger')
                                    ->weight('bold')
                                    ->placeholder(__('No discount')),
                                TextEntry::make('is_active')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive')),
                                TextEntry::make('is_featured')
                                    ->label(__('Is Featured'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'warning' : 'gray')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Featured') : __('Standard')),
                            ]),
                    ]),
            ]);
    }
}