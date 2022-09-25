<?php

namespace App\Repositories;

use App\Contracts\CategoryContracts;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CategoryRepository extends BaseRepository implements CategoryContracts
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }

    public function listCategories(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null)
    {
        return $pagination ? $this->all($orderBy, $sortBy, $columns, $pagination) : $this->all($orderBy, $sortBy, $columns);
    }

    public function findCategoryById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function createCategory(array $attributes)
    {
        try {
            return $this->create($attributes);
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function updateCategory(int $id, array $attributes)
    {
        try {
            $category = $this->findCategoryById($id);
            $category->update($attributes);
            return $category;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }

    }

    public function deleteCategory(int $id)
    {
        $category = $this->findCategoryById($id);
        $category->delete();
        return $category;
    }

    public function findCategoryBySlug(string $slug, int $pagination = null)
    {
        return $pagination ? $this->findBy(['slug' => $slug], $pagination) : $this->findBy(['slug' => $slug]);
    }
}
