<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Services\FavoriteService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponse;

    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Toggle favorite status of a product.
     *
     * @param \App\Http\Requests\API\ToggleFavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(\App\Http\Requests\API\ToggleFavoriteRequest $request)
    {
        $result = $this->favoriteService->toggleFavorite(
            $request->user()->id,
            $request->product_id
        );

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->messageOnly($result['message']);
    }

    /**
     * List favorite products.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $favorites = $this->favoriteService->getFavorites($request->user()->id, $request->per_page ?? 15);
        return $this->success(FavoriteResource::collection($favorites)->response()->getData(true), __('messages.success'));
    }
}
