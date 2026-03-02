<?php

namespace App\Filament\Resources\OrderReviews\Pages;

use App\Filament\Resources\OrderReviews\OrderReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderReview extends CreateRecord
{
    protected static string $resource = OrderReviewResource::class;
}
