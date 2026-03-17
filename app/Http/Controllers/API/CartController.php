<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddToCartRequest;
use App\Http\Requests\deleteCartRequest;
use App\Http\Requests\updateCartRequest;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->getCart($request->user()->id);
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->success($result['data'], $result['message']);
    }

    public function add(AddToCartRequest $request)
    {
        $result = $this->cartService->addItem($request->user()->id, $request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->messageOnly($result['message']);
    }

    public function update(updateCartRequest $request, $productId)
    {
        $result = $this->cartService->updateItem($request->user()->id, $productId, $request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->messageOnly($result['message']);
    }

    public function remove(deleteCartRequest $request, $productId)
    {
        $result = $this->cartService->removeItem($request->user()->id, $request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }
        return $this->messageOnly($result['message']);
    }

    public function clear(Request $request)
    {
        $result = $this->cartService->clearCart($request->user()->id);
        return $this->success($result['data'], $result['message']);
    }
}
