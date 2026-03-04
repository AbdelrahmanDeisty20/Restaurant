<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class productService
{
    public function getAllProducts()
    {
        $products = Product::paginate(10);
        if($products->isEmpty()){
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
}