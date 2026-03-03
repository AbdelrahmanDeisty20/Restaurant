<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\productService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    protected $productService;
    public function __construct(productService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->getAllProducts();
        if(!$products['status']){
            return $this->error($products['message'], 404);
        }
        return $this->paginated(ProductResource::class, $products['data'], $products['message']);
    }
}
