<?php

namespace App\Filament\Resources\BestProductSellers\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BestProductSellerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Core Featured Product'))
                    ->icon('heroicon-o-star')
                    ->description(__('Details of the product currently highlighted.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('product.name_' . app()->getLocale())
                                    ->label(__('Product Name'))
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-m-cube'),
                                TextEntry::make('product.category.name')
                                    ->label(__('Category'))
                                    ->icon('heroicon-m-tag'),
                                TextEntry::make('is_active')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive')),
                            ]),
                    ]),

                Section::make(__('Override Content'))
                    ->icon('heroicon-o-pencil-square')
                    ->description(__('Custom representation for the storefront.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name_ar')
                                    ->label(__('Name AR (Override)'))
                                    ->placeholder(__('Using product name'))
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('name_en')
                                    ->label(__('Name EN (Override)'))
                                    ->placeholder(__('Using product name'))
                                    ->icon('heroicon-m-language'),
                                ImageEntry::make('image')
                                    ->label(__('Image (Override)'))
                                    ->disk('public')
                                    ->circular()
                                    ->size(100)
                                    ->placeholder(__('Using product image')),
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('description_ar')
                                            ->label(__('Description AR (Override)'))
                                            ->prose()
                                            ->placeholder(__('Using product description')),
                                        TextEntry::make('description_en')
                                            ->label(__('Description EN (Override)'))
                                            ->prose()
                                            ->placeholder(__('Using product description')),
                                    ])->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
