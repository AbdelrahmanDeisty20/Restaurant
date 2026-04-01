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
                // الحالة الأولى: المنتج له سعر أساسي (> 0)
                // في هذه الحالة، السعر الأساسي هو اللي بيظهر للعميل، فلازم يكون هو اللي في النطاق
                $q->where(function ($sub) use ($min, $max) {
                    $sub->where('price', '>', 0)
                        ->whereBetween('price', [$min, $max]);
                })
                // الحالة الثانية: المنتج سعره الأساسي 0
                // هنا بنعتمد على "أقل" سعر في الأحجام (Sizes) كما هو في الـ Resource
                ->orWhere(function ($sub) use ($min, $max) {
                    $sub->where('price', '<=', 0)
                        ->whereHas('sizes', function ($sizeQuery) use ($min, $max) {
                            // نتحقق أن أقل سعر في الأحجام موجود في النطاق
                            $sizeQuery->selectRaw('min(price)')
                                ->havingRaw('min(price) >= ?', [$min])
                                ->havingRaw('min(price) <= ?', [$max]);
                        });
                });
            });
        }

        // 3. عروض خاصة (Special Offers)
        // الفلترة فقط
        if (!empty($filters['special_offers'])) {
            $query->whereHas('offers', function ($q) {
                $q->where('is_active', true)->where('end_date', '>=', now());
            });
        }

        // 4. التقييمات (Ratings)
        if (!empty($filters['ratings'])) {
            $query->withAvg('productReviews', 'rating')
                ->having('product_reviews_avg_rating', '>=', $filters['ratings']);
        }

        // 5. الترتيب (Sorting)
        // هذا هو الجزء الذي يطلبه يوسف الآن
        $sort = $filters['sort'] ?? 'latest';

        switch ($sort) {
            case 'min_price':
            case 'max_price':
                // نستخدم selectRaw لحساب السعر المعروض (displayed_price) بدقة للترتيب عليه
                $query->selectRaw('*, CASE 
                        WHEN price > 0 THEN price 
                        ELSE (SELECT MIN(price) FROM product_sizes WHERE product_id = products.id)
                    END as displayed_price')
                    ->orderBy('displayed_price', $sort === 'min_price' ? 'asc' : 'desc');
                break;

            case 'offers':
                // ترتيب المنتجات التي لديها عروض نشطة لتظهر في البداية
                $query->leftJoin('offers', function($join) {
                        $join->on('products.id', '=', 'offers.product_id')
                            ->where('offers.is_active', true)
                            ->where('offers.end_date', '>=', now());
                    })
                    ->select('products.*')
                    ->orderByRaw('CASE WHEN offers.id IS NOT NULL THEN 0 ELSE 1 END');
                break;

            case 'latest':
            default:
                $query->orderByDesc('id');
                break;
        }

        $products = $query->paginate(10);

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
