<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Category Identity'))
                    ->icon('heroicon-o-tag')
                    ->description(__('Visual and naming details of the category.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ImageEntry::make('image')
                                    ->label(__('Image'))
                                    ->disk('public')
                                    ->circular()
                                    ->size(100),
                                Grid::make(1)
                                    ->columnSpan(2)
                                    ->schema([
                                        TextEntry::make('name_ar')
                                            ->label(__('Name AR'))
                                            ->weight('bold')
                                            ->icon('heroicon-m-language'),
                                        TextEntry::make('name_en')
                                            ->label(__('Name EN'))
                                            ->weight('bold')
                                            ->icon('heroicon-m-language'),
                                    ]),
                            ]),
                    ]),

                Section::make(__('Category Status'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description(__('Visibility and system settings.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('is_active')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive')),
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
