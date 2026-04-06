<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Identity'))
                    ->icon('heroicon-o-user')
                    ->description(__('Basic profile information and avatar.'))
                    ->columns(2)
                    ->components([
                        FileUpload::make('avatar')
                            ->label(__('Avatar'))
                            ->disk('public')
                            ->directory('users/avatars')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->columnSpan(1),
                        TextInput::make('full_name')
                            ->label(__('Full Name'))
                            ->required()
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(1),
                    ]),

                Section::make(__('Contact Details'))
                    ->icon('heroicon-o-at-symbol')
                    ->description(__('How we reach the user.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('email')
                            ->label(__('Email address'))
                            ->email()
                            ->required()
                            ->prefixIcon('heroicon-m-envelope'),
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->required()
                            ->prefixIcon('heroicon-m-phone'),
                    ]),

                Section::make(__('Security & Access'))
                    ->icon('heroicon-o-shield-check')
                    ->description(__('Manage account verification, roles, and status.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            ->prefixIcon('heroicon-m-key'),
                        DateTimePicker::make('email_verified_at')
                            ->label(__('Email Verified At'))
                            ->prefixIcon('heroicon-m-check-badge'),
                        Select::make('roles')
                            ->label(__('Roles'))
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->visible(fn() => auth()->user()->can('Update:Role'))
                            ->prefixIcon('heroicon-m-user-group'),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required()
                            ->default(true)
                            ->inline(false)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}