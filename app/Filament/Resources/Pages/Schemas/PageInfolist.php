<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Page Identification'))
                    ->icon('heroicon-o-document-duplicate')
                    ->description(__('How the page is identified in both languages.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('title_ar')
                                    ->label(__('Title (Arabic)'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('title_en')
                                    ->label(__('Title (English)'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                            ]),
                    ]),

                Section::make(__('Content Preview'))
                    ->icon('heroicon-o-book-open')
                    ->description(__('Snapshot of the page content.'))
                    ->schema([
                        TextEntry::make('content_ar')
                            ->label(__('Content (Arabic)'))
                            ->prose()
                            ->html()
                            ->columnSpanFull(),
                        TextEntry::make('content_en')
                            ->label(__('Content (English)'))
                            ->prose()
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Metadata'))
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar'),
                                TextEntry::make('updated_at')
                                    ->label(__('Last Update'))
                                    ->dateTime()
                                    ->icon('heroicon-m-clock'),
                            ]),
                    ]),
            ]);
    }
}
