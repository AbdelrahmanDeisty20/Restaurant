<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Models\Offer;

class OfferService
{
    public function getAllOffers()
    {
        $offers = Offer::with('product')->paginate(10);
        if ($offers->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.offers_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.offers_retrieved_successfully'),
            'data' => OfferResource::collection($offers),
        ];
    }
}