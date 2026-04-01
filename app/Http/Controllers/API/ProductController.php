<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\FilterProductRequest;
use App\Http\Requests\API\SearchProductRequest;
use App\Http\Resources\BestProductSellerResource;
use App\Http\Resources\ProductExtraResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSizeResource;
use App\Services\productService;
use App\Services\SearchProductService;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    protected $productService;
    protected $searchProductService;

    public function __construct(productService $productService, SearchProductService $searchProductService)
    {
        $this->productService = $productService;
        $this->searchProductService = $searchProductService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        if (!$products['status']) {
            return $this->error($products['message'], 404);
        }
        return $this->paginated(ProductResource::class, $products['data'], $products['message']);
    }

    public function filter(FilterProductRequest $request)
    {
        $products = $this->productService->filterProducts($request->validated());
        if (!$products['status']) {
            return $this->error($products['message'], 404);
        }
        return $this->paginated(ProductResource::class, $products['data'], $products['message']);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        if (!$product['status']) {
            return $this->error($product['message'], 404);
        }
        return $this->success($product['data'], $product['message']);
    }

    public function search(SearchProductRequest $request)
    {
        $products = $this->searchProductService->searchProducts($request->validated());
        if (!$products['status']) {
            return $this->error($products['message'], 404);
        }
        return $this->paginated(ProductResource::class, $products['data'], $products['message']);
    }

    public function getProductExtras()
    {
        $productExtras = $this->productService->getProductExtras();
        if (!$productExtras['status']) {
            return $this->error($productExtras['message'], 404);
        }
        return $this->paginated(ProductExtraResource::class, $productExtras['data'], $productExtras['message']);
    }

    public function getProductSizes()
    {
        $productSizes = $this->productService->getProductSizes();
        if (!$productSizes['status']) {
            return $this->error($productSizes['message'], 404);
        }
        return $this->paginated(ProductSizeResource::class, $productSizes['data'], $productSizes['message']);
    }

    public function getBestSellers()
    {
        $bestSellers = $this->productService->getBestSellers();
        if (!$bestSellers['status']) {
            return $this->error($bestSellers['message'], 404);
        }
        return $this->success(BestProductSellerResource::collection($bestSellers['data']), $bestSellers['message']);
    }
}
