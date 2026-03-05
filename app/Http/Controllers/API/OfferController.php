<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Services\OfferService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use ApiResponse;
    protected $offerService;
    public function __construct(OfferService $offerService) {
       $this->offerService = $offerService;
    }
    public function index()
    {
        $offers = $this->offerService->getAllOffers();
        if(!$offers['status']){
            return $this->error($offers['message']);
        }
        return $this->paginated(OfferResource::class,$offers['data'], $offers['message']);
    }
}
