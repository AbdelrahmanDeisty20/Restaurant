<?php

namespace App\Filament\Resources\OrderReviews\Pages;

use App\Filament\Resources\OrderReviews\OrderReviewResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderReview extends ViewRecord
{
    protected static string $resource = OrderReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
