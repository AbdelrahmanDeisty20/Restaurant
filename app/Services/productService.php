<?php

namespace App\Services;

use App\Http\Resources\ProductExtraResource;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductSizeResource;
use App\Models\Product;
use App\Models\ProductExtra;
use App\Models\ProductSize;

class productService
{
    public function getAllProducts()
    {
        // بنحمل الـ sizes عشان نعرف نجيب أقل سعر بره
        $products = Product::with(['offers'])->paginate(10);
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
            'data' => $products, // نرجع الموديل نفسه عشان المتحكم يقدر يعمله Pagination صح
        ];
    }

    public function getProductById($id)
    {
        $product = Product::with(['offers', 'images', 'category', 'sizes', 'reviews'])->find($id);
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
            'data' => new ProductListResource($product), // المورد اللي جواه كل حاجة (تفاصيل)
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
            'data' => $productExtras,
        ];
    }

    public function getProductSizes()
    {
        $productSizes = ProductSize::paginate(10);
        if ($productSizes->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.product_sizes_not_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.product_sizes_retrieved_successfully'),
            'data' => $productSizes,
        ];
    }
}
