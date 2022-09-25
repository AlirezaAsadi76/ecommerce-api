<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\TagContracts;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use F9Web\ApiResponseHelpers;

class TagController extends Controller
{
    use ApiResponseHelpers;

    private TagContracts $tagRepository;

    public function __construct(TagContracts $tagRepository)
    {
        $this->tagRepository=$tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tags = $this->tagRepository->listTags();

        return $this->respondWithSuccess(new TagCollection($tags));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request)
    {
        $tag = $this->tagRepository->createTag($request->validated());
        if (!$tag) {
            return $this->respondError('Error occurred while creating tag');
        }

        return $this->respondCreated(new TagResource($tag));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTagRequest $request, $id)
    {
        $tag = $this->tagRepository->updateTag($id, $request->validated());
        if (!$tag) {
            return $this->respondError('Error occurred while creating tag');
        }

        return $this->respondWithSuccess(new TagResource($tag));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $tag = $this->tagRepository->deleteTag($id);
        if (!$tag) {
            return $this->respondError("Error occurred while deleting tag.");
        }
        return $this->respondOk('deleted successfully');
    }
}
