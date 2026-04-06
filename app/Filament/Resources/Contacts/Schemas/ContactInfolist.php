<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ContactInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Contact Information'))
                    ->icon('heroicon-o-user')
                    ->description(__('Basic details of the person who contacted us.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Name'))
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('email')
                                    ->label(__('Email address'))
                                    ->icon('heroicon-m-envelope')
                                    ->copyable(),
                                TextEntry::make('phone')
                                    ->label(__('Phone'))
                                    ->icon('heroicon-m-phone')
                                    ->copyable(),
                            ]),
                    ]),

                Section::make(__('Message Content'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->description(__('The specific details and message received.'))
                    ->schema([
                        TextEntry::make('subject')
                            ->label(__('Subject'))
                            ->weight('bold')
                            ->color('primary'),
                        TextEntry::make('message')
                            ->label(__('Message'))
                            ->prose()
                            ->columnSpanFull()
                            ->alignJustify(),
                        TextEntry::make('created_at')
                            ->label(__('Sent At'))
                            ->dateTime()
                            ->color('gray'),
                    ]),
            ]);
    }
}
