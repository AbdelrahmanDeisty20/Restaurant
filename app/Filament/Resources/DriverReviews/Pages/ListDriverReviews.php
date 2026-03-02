<?php

namespace App\Filament\Resources\DriverReviews\Pages;

use App\Filament\Resources\DriverReviews\DriverReviewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDriverReviews extends ListRecords
{
    protected static string $resource = DriverReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
