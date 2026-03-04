<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name_ar')
                    ->label(__('Name AR')),
                TextEntry::make('name_en')
                    ->label(__('Name EN')),
                ImageEntry::make('main_image')
                    ->label(__('Main Image'))
                    ->disk('public'),
                TextEntry::make('category.name')
                    ->label(__('Category')),
                TextEntry::make('price')
                    ->label(__('Price'))
                    ->money('EGP'),
                TextEntry::make('discount_price')
                    ->label(__('Discount Price'))
                    ->money('EGP'),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
                IconEntry::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
                IconEntry::make('is_featured')
                    ->label(__('Is Featured'))
                    ->boolean(),
            ]);
    }
}
