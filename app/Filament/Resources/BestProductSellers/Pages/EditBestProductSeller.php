<?php

namespace App\Filament\Resources\BestProductSellers\Pages;

use App\Filament\Resources\BestProductSellers\BestProductSellerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBestProductSeller extends EditRecord
{
    protected static string $resource = BestProductSellerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
