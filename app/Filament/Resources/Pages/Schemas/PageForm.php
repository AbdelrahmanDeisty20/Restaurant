<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_ar')
                    ->label(__('Title (Arabic)'))
                    ->required(),
                TextInput::make('title_en')
                    ->label(__('Title (English)'))
                    ->required(),
                Textarea::make('content_ar')
                    ->label(__('Content (Arabic)'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content_en')
                    ->label(__('Content (English)'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('sections')
                    ->label(__('Sections'))
                    ->columnSpanFull(),
            ]);
    }
}
