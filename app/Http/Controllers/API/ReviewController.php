<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'product_reviews' => 'nullable|array',
            'product_reviews.*.product_id' => 'required|exists:products,id',
            'product_reviews.*.rating' => 'required|integer|min:1|max:5',
            'product_reviews.*.comment' => 'nullable|string',
            'driver_review' => 'nullable|array',
            'driver_review.driver_id' => 'required|exists:drivers,id',
            'driver_review.rating' => 'required|integer|min:1|max:5',
            'driver_review.comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422, $validator->errors());
        }

        $review = $this->reviewService->storeReview($request->all());

        return $this->created(new OrderReviewResource($review), 'Review submitted successfully');
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
