<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name_ar')
                    ->label(__('Name AR')),
                TextEntry::make('name_en')
                    ->label(__('Name EN')),
                ImageEntry::make('image')
                    ->label(__('Image'))
                    ->disk('public')
                    ->formatStateUsing(fn($state) => $state ? "categories/{$state}" : null),
                IconEntry::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ]);
    }
}
