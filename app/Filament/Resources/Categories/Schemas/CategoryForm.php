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
                    ->nullable(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->nullable(),
                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->formatStateUsing(fn($state) => $state && !str_starts_with($state, 'categories/') ? "categories/{$state}" : $state)
                    ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                    ->nullable()
                    ->imagePreviewHeight('150')
                    ->downloadable(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
            ]);
    }
}