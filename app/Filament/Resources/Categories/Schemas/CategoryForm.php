<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Name AR'))
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->name_ar))
                    ->nullable(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->name_en))
                    ->nullable(),
                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    // This hook ensures Filament finds the file in 'categories/' for the preview
                    ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "categories/{$state}" : $state)
                    // This hook strips the 'categories/' prefix before saving to DB, to match your Model accessor
                    ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->image))
                    ->nullable(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
            ]);
    }
}