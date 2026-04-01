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
        $products = Product::with(['offers', 'images', 'productReviews', 'sizes'])->paginate(10);
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
            'data' => $products,  // نرجع الموديل نفسه عشان المتحكم يقدر يعمله Pagination صح
        ];
    }

    public function filterProducts(array $filters = [])
    {
        $query = Product::with(['offers', 'images', 'productReviews', 'sizes']);

        // 1. الفلترة بالتصنيف (Category Filter)
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // 2. الفلترة بالسعر (Price Range)
        if (isset($filters['min_price']) || isset($filters['max_price'])) {
            $min = $filters['min_price'] ?? 0;
            $max = $filters['max_price'] ?? 999999;

            $query->where(function ($q) use ($min, $max) {
                $q->where(function ($sub) use ($min, $max) {
                    $sub->where('price', '>', 0)
                        ->whereBetween('price', [$min, $max]);
                })
                    ->orWhereHas('sizes', function ($sub) use ($min, $max) {
                        $sub->whereBetween('price', [$min, $max]);
                    });
            });
        }

        // 3. عروض خاصة (Special Offers)
        if (!empty($filters['special_offers'])) {
            $query->whereHas('offers', function ($q) {
                $q->where('is_active', true)->where('end_date', '>=', now());
            });
        }

        // 4. الأكثر مبيعاً (Most Sold)
        if (!empty($filters['most_sold'])) {
            $query->withSum('orders as total_sales', 'order_items.quantity')
                ->orderByDesc('total_sales');
        }

        // 5. التقييمات (Ratings)
        if (!empty($filters['ratings'])) {
            $query->withAvg('productReviews', 'rating')
                ->having('product_reviews_avg_rating', '>=', $filters['ratings']);
        }

        // 6. وصل حديثاً (New Arrivals)
        if (!empty($filters['new_arrivals'])) {
            $query->orderByDesc('created_at');
        } else if (empty($filters['most_sold'])) {
            $query->orderByDesc('id');
        }

        $products = $query->paginate(12);

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
            'data' => $products,
        ];
    }

    public function getProductById($id)
    {
        $product = Product::with(['offers', 'images', 'category', 'sizes', 'productReviews'])->find($id);
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
            'data' => new ProductListResource($product),  // المورد اللي جواه كل حاجة (تفاصيل)
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

    public function getBestSellers()
    {
        $bestSellers = \App\Models\BestProductSeller::with(['product.offers', 'product.images', 'product.productReviews', 'product.sizes'])
            ->where('is_active', true)
            ->get();

        if ($bestSellers->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.products_not_found'),
                'data' => [],
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.products_retrieved_successfully'),
            'data' => $bestSellers,
        ];
    }
}
