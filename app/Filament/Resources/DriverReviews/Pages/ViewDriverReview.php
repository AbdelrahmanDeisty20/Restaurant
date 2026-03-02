<?php

namespace App\Filament\Resources\DriverReviews\Pages;

use App\Filament\Resources\DriverReviews\DriverReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDriverReview extends ViewRecord
{
    protected static string $resource = DriverReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
