<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class OfferInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Promoted Product'))
                    ->icon('heroicon-o-shopping-bag')
                    ->description(__('The specific item being featured in this campaign.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('product.name_' . app()->getLocale())
                                    ->label(__('Product'))
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-m-cube'),
                                TextEntry::make('product.category.name')
                                    ->label(__('Category'))
                                    ->icon('heroicon-m-tag'),
                            ]),
                    ]),

                Section::make(__('Campaign Details'))
                    ->icon('heroicon-o-gift')
                    ->description(__('Discount Rules and Active Timeline.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('discount_percentage')
                                    ->label(__('Discount'))
                                    ->suffix('%')
                                    ->weight('bold')
                                    ->color('danger')
                                    ->icon('heroicon-m-receipt-percent'),
                                TextEntry::make('start_date')
                                    ->label(__('Starts'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar-days'),
                                TextEntry::make('end_date')
                                    ->label(__('Ends'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar-days'),
                            ]),
                    ]),

                Section::make(__('Campaign Status'))
                    ->icon('heroicon-o-signal')
                    ->description(__('Current visibility of the offer.'))
                    ->schema([
                        TextEntry::make('is_active')
                            ->label(__('Status'))
                            ->badge()
                            ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive'))
                            ->icon('heroicon-m-flag'),
                    ]),
            ]);
    }
}
