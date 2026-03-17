<?php
namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class SearchProductService
{
    public function searchProducts(array $data)
    {
        $products = Product::with('offers')->where('name_ar', 'like', "%{$data['search']}%")->orWhere('name_en', 'like', "%{$data['search']}%")->paginate(10);
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
}
