<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProductReviewRequest;
use App\Http\Requests\API\StoreReviewRequest;
use App\Http\Requests\API\UpdateReviewRequest;
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

        return $this->created(new OrderReviewResource($review), __('messages.review_submitted_successfully'));
    }

    /**
     * Store an independent product review.
     */
    public function storeProductReview(StoreProductReviewRequest $request)
    {
        $review = $this->reviewService->storeProductReview($request->validated());

        return $this->created(new ProductReviewResource($review), __('messages.product_review_submitted_successfully'));
    }

    /**
     * Get reviews for a specific product.
     */
    public function getProductReviews($productId)
    {
        $reviews = $this->reviewService->getProductReviews($productId);
        return $this->paginated(ProductReviewResource::class, $reviews);
    }

    /**
     * Update a product review.
     */
    public function updateProductReview(UpdateReviewRequest $request, $id)
    {
        $result = $this->reviewService->updateProductReview($id, $request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 403);
        }

        return $this->success(new ProductReviewResource($result['data']), $result['message']);
    }

    /**
     * Delete a product review.
     */
    public function deleteProductReview($id)
    {
        $result = $this->reviewService->deleteProductReview($id);

        if (!$result['status']) {
            return $this->error($result['message'], 403);
        }

        return $this->success([], $result['message']);
    }

    /**
     * Update an order review.
     */
    public function updateOrderReview(UpdateReviewRequest $request, $id)
    {
        $result = $this->reviewService->updateOrderReview($id, $request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 403);
        }

        return $this->success(new OrderReviewResource($result['data']), $result['message']);
    }

    /**
     * Delete an order review.
     */
    public function deleteOrderReview($id)
    {
        $result = $this->reviewService->deleteOrderReview($id);

        if (!$result['status']) {
            return $this->error($result['message'], 403);
        }

        return $this->success(null, $result['message']);
    }
}
