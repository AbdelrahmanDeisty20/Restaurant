<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Page Identification'))
                    ->icon('heroicon-o-document-duplicate')
                    ->description(__('Bilingual titles for the static page.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title_ar')
                                    ->label(__('Title (Arabic)'))
                                    ->required()
                                    ->icon('heroicon-m-language'),
                                TextInput::make('title_en')
                                    ->label(__('Title (English)'))
                                    ->required()
                                    ->icon('heroicon-m-language'),
                            ]),
                    ]),

                Section::make(__('Page Content'))
                    ->icon('heroicon-o-pencil-square')
                    ->description(__('Full content and specialized sections.'))
                    ->schema([
                        RichEditor::make('content_ar')
                            ->label(__('Content (Arabic)'))
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('content_en')
                            ->label(__('Content (English)'))
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('sections')
                            ->label(__('Specialized Sections'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
