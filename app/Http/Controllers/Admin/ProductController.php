<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryContracts;
use App\Contracts\ProductContracts;
use App\Contracts\TagContracts;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Product;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends Controller
{
    use ApiResponseHelpers;

    private ProductContracts $productRepository;
    private CategoryContracts $categoryRepository;
    private TagContracts $tagRepository;
    public function __construct(
        ProductContracts $productRepository,
        CategoryContracts $categoryRepository,
        TagContracts $tagRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->listProducts();
        return $this->respondWithSuccess(new ProductCollection($products));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        $tags = $this->tagRepository->listTags();
        $categories = $this->categoryRepository->listCategories();

        return $this->respondWithSuccess([
            'categories' => new CategoryCollection($categories),
            'tags' => new TagCollection($tags)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->createProduct($request->validated());
        if (!$product) {
            return $this->respondError('Error occurred while creating product.');
        }
        return $this->respondWithSuccess(new ProductResource($product));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return JsonResponse
     */
    public function edit($id)
    {
        $tags = $this->tagRepository->listTags();
        $categories = $this->categoryRepository->listCategories();
        $product = $this->productRepository->findProductById($id);

        return $this->respondWithSuccess([
            'product' => new ProductResource($product),
            'categories' => new CategoryCollection($categories),
            'tags' => new TagCollection($tags)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $product = $this->productRepository->updateProduct($id,$request->validated());
        if (!$product) {
            return $this->respondError("Error occurred while updating product.");
        }
        return $this->respondWithSuccess(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $product = $this->productRepository->deleteProduct($id);
        if (!$product) {
            return $this->respondError("Error occurred while deleting product.");
        }
        return $this->respondOk('deleted successfully');
    }
}
