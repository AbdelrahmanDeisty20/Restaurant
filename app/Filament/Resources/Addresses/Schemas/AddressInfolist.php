<?php

namespace App\Filament\Resources\Addresses\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AddressInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.full_name')
                    ->label(__('User'))
                    ->url(fn ($record) =>
                        UserResource::getUrl('view', ['record' => $record->user])
                    )
                    ->openUrlInNewTab(),
                TextEntry::make('title')
                    ->label(__('Title')),
                IconEntry::make('is_default')
                    ->label(__('Is Default'))
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
