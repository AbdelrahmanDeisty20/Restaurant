<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.full_name')
                    ->label(__('User'))
                    ->numeric(),
                TextEntry::make('total_price')
                    ->label(__('Total Price'))
                    ->numeric(),
                TextEntry::make('status')
                    ->label(__('Status')),
                TextEntry::make('notes')
                    ->label(__('Notes')),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ]);
    }
}
