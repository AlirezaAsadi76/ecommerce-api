<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContracts;
use App\Contracts\ProductContracts;
use App\Contracts\TagContracts;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    use ApiResponseHelpers;

    private ProductContracts $productRepository;
    private CategoryContracts $categoryRepository;

    public function __construct(
        ProductContracts $productRepository,
        CategoryContracts $categoryRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;

    }

    public function index()
    {
        $products = $this->productRepository->listProducts(pagination: 15);
        $categories = $this->categoryRepository->listCategories(pagination: 15);
        return $this->respondWithSuccess([
            'products' => ProductResource::collection($products),
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    public function show(string $slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);

        if (!$product){
            return $this->respondNotFound('product not found');
        }

        return $this->respondWithSuccess(new ProductResource($product));
    }

    public function search($query)
    {

    }
}
