<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryContracts;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use F9Web\ApiResponseHelpers;

class CategoryController extends Controller
{
    use ApiResponseHelpers;

    private CategoryContracts $categoryRepository;

    public function __construct(CategoryContracts $categoryRepository)
    {
        $this->categoryRepository=$categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        return $this->respondWithSuccess(new CategoryCollection($categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->createCategory($request->validated());

        if (!$category) {
            return $this->respondError('Error occurred while creating category');
        }

        return $this->respondCreated(new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->updateCategory($id, $request->validated());
        if (!$category) {
            return $this->respondError('Error occurred while creating category');
        }

        return $this->respondWithSuccess(new CategoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);
        if (!$category) {
            return $this->respondError("Error occurred while deleting category.");
        }

        return $this->respondOk('deleted successfully');
    }
}
