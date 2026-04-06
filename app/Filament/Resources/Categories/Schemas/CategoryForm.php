<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Category Identity'))
                    ->icon('heroicon-o-tag')
                    ->description(__('Basic details and representation of the category.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->required()
                                    ->prefixIcon('heroicon-m-language'),
                                TextInput::make('name_en')
                                    ->label(__('Name EN'))
                                    ->required()
                                    ->prefixIcon('heroicon-m-language'),
                            ]),
                        FileUpload::make('image')
                            ->label(__('Image'))
                            ->image()
                            ->disk('public')
                            ->directory('categories')
                            ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "categories/{$state}" : $state)
                            ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                            ->nullable()
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Category Settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description(__('Visibility and activation toggle.'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}