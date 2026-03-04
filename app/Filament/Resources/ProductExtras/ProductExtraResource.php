<?php

namespace App\Filament\Resources\ProductExtras;

use App\Filament\Resources\ProductExtras\Pages\CreateProductExtra;
use App\Filament\Resources\ProductExtras\Pages\EditProductExtra;
use App\Filament\Resources\ProductExtras\Pages\ListProductExtras;
use App\Filament\Resources\ProductExtras\Pages\ViewProductExtra;
use App\Filament\Resources\ProductExtras\Schemas\ProductExtraForm;
use App\Filament\Resources\ProductExtras\Schemas\ProductExtraInfolist;
use App\Filament\Resources\ProductExtras\Tables\ProductExtrasTable;
use App\Models\ProductExtra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductExtraResource extends Resource
{
    protected static ?string $model = ProductExtra::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Shop');
    }

    public static function getLabel(): ?string
    {
        return __('Product Extra');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Product Extras');
    }

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    public static function form(Schema $schema): Schema
    {
        return ProductExtraForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductExtraInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductExtrasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListProductExtras::route('/'),
            'create' => CreateProductExtra::route('/create'),
            'view'   => ViewProductExtra::route('/{record}'),
            'edit'   => EditProductExtra::route('/{record}/edit'),
        ];
    }
}
