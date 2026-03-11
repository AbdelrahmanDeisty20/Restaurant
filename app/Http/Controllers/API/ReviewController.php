<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProductReviewRequest;
use App\Http\Requests\API\StoreReviewRequest;
use App\Http\Resources\OrderReviewResource;
use App\Http\Resources\ProductReviewResource;
use App\Services\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use ApiResponse;

    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Store a new review.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = $this->reviewService->storeReview($request->validated());

        return $this->created(new OrderReviewResource($review), 'Review submitted successfully');
    }

    /**
     * Store an independent product review.
     */
    public function storeProductReview(StoreProductReviewRequest $request)
    {
        $review = $this->reviewService->storeProductReview($request->validated());

        return $this->created(new ProductReviewResource($review), 'Product review submitted successfully');
    }

    /**
     * Get reviews for a specific product.
     */
    public function getProductReviews($productId)
    {
        $reviews = $this->reviewService->getProductReviews($productId);
        return $this->paginated(ProductReviewResource::class, $reviews);
    }
}
