<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('User Identification'))
                    ->icon('heroicon-o-user-circle')
                    ->description(__('Primary identification and profile picture.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ImageEntry::make('avatar')
                                    ->label(__('Avatar'))
                                    ->disk('public')
                                    ->circular()
                                    ->size(100),
                                TextEntry::make('full_name')
                                    ->label(__('Full Name'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-user')
                                    ->columnSpan(2),
                            ]),
                    ]),

                Section::make(__('Contact Details'))
                    ->icon('heroicon-o-at-symbol')
                    ->description(__('Communication channels for the user.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
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

                Section::make(__('Account Status & Metadata'))
                    ->icon('heroicon-o-shield-check')
                    ->description(__('System details regarding current account state.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('is_active')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive')),
                                TextEntry::make('email_verified_at')
                                    ->label(__('Verified At'))
                                    ->dateTime()
                                    ->icon('heroicon-m-check-badge')
                                    ->color('primary')
                                    ->placeholder(__('Not Verified')),
                                TextEntry::make('created_at')
                                    ->label(__('Member Since'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar'),
                            ]),
                    ]),
            ]);
    }
}
