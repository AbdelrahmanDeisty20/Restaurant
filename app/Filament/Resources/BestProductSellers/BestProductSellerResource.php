<?php

namespace App\Filament\Resources\BestProductSellers;

use App\Filament\Resources\BestProductSellers\Pages\CreateBestProductSeller;
use App\Filament\Resources\BestProductSellers\Pages\EditBestProductSeller;
use App\Filament\Resources\BestProductSellers\Pages\ListBestProductSellers;
use App\Filament\Resources\BestProductSellers\Schemas\BestProductSellerForm;
use App\Filament\Resources\BestProductSellers\Tables\BestProductSellersTable;
use App\Models\BestProductSeller;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BestProductSellerResource extends Resource
{
    protected static ?string $model = BestProductSeller::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Shop');
    }

    public static function getLabel(): ?string
    {
        return __('Best Seller');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Best Sellers');
    }

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public static function form(Schema $schema): Schema
    {
        return BestProductSellerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BestProductSellersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBestProductSellers::route('/'),
            'create' => CreateBestProductSeller::route('/create'),
            'edit' => EditBestProductSeller::route('/{record}/edit'),
        ];
    }
}
