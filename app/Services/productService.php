<?php

namespace App\Services;

use App\Http\Resources\ProductExtraResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductExtra;

class productService
{
    public function getAllProducts()
    {
        $products = Product::with('offers')->paginate(10);
        if ($products->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.products_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.products_retrieved_successfully'),
            'data' => ProductResource::collection($products),
        ];
    }
    public function getProductById($id)
    {
        $product = Product::with('offers','images','category')->find($id);
        if (!$product) {
            return [
                'status' => false,
                'message' => __('messages.product_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.product_retrieved_successfully'),
            'data' => new ProductResource($product),
        ];
    }
    public function getProductExtras()
    {
        $productExtras = ProductExtra::paginate(10);
        if ($productExtras->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.product_extras_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.product_extras_retrieved_successfully'),
            'data' => ProductExtraResource::collection($productExtras),
        ];
    }
}
