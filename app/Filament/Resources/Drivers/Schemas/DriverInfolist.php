<?php

namespace App\Filament\Resources\Drivers\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DriverInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.full_name')
                    ->label(__('User')),
                TextEntry::make('phone')
                    ->label(__('Phone')),
                ImageEntry::make('avatar')
                    ->label(__('Avatar'))
                    ->disk('public'),
                TextEntry::make('status')
                    ->label(__('Status')),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ]);
    }
}
