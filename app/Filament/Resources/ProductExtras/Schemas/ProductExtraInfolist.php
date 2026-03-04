<?php

namespace App\Filament\Resources\ProductExtras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductExtraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name_ar')
                    ->label(__('Name AR')),
                TextEntry::make('name_en')
                    ->label(__('Name EN')),
                TextEntry::make('price')
                    ->label(__('Price'))
                    ->money('EGP'),
                TextEntry::make('type')
                    ->label(__('Type')),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ]);
    }
}
