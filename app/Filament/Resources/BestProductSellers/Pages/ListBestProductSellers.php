<?php

namespace App\Filament\Resources\BestProductSellers\Pages;

use App\Filament\Resources\BestProductSellers\BestProductSellerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBestProductSellers extends ListRecords
{
    protected static string $resource = BestProductSellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
