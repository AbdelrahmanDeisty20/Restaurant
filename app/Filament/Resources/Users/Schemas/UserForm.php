<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                    ->label(__('Full Name'))
                    ->required()
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id()),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->required()
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id()),
                FileUpload::make('avatar')
                    ->label(__('Avatar'))
                    ->disk('public')
                    ->directory('users/avatars')
                    ->image()
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id()),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->required()
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id()),
                DateTimePicker::make('email_verified_at')
                    ->label(__('Email Verified At'))
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id()),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->dehydrated(fn($state) => filled($state))
                    ->disabled(fn(?User $record) => $record && $record->id !== auth()->id())
                    ->hidden(fn(?User $record) => $record && $record->id !== auth()->id()),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->required(),
                Select::make('roles')
                    ->label(__('Roles'))
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->visible(fn() => auth()->user()->can('Update:Role')),
            ]);
    }
}