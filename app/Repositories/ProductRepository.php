<?php

namespace App\Repositories;

use App\Contracts\ProductContracts;
use App\Models\ProductTag;
use App\Models\Tag;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductRepository extends BaseRepository implements ProductContracts
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listProducts(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null)
    {
        return $pagination ? $this->all($orderBy, $sortBy, $columns, $pagination) : $this->all($orderBy, $sortBy, $columns);
    }

    public function findProductById(int $id)
    {
        try {
           return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function createProduct(array $attributes)
    {
        try {
            $collection = collect($attributes);

            unset($attributes['tags']);
            $product = $this->create($attributes);

            if ($collection->has('category')) {
                $product->category()->sync($attributes['category']);
            }
            if ($collection->has('tags')) {
                $product->tags()->sync($collection['tags']);
            }

            return $product;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }


    public function updateProduct(int $id, array $attributes)
    {
        try {
            $collection = collect($attributes);
            $product = $this->findProductById($id);
            unset($attributes['tags']);
            $product->update($attributes);

            if ($collection->has('tags')) {
                $product->tags()->sync($collection['tags']);
            }
           return $product;

        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }

    }

    public function deleteProduct(int $id)
    {

        $product = $this->findProductById($id);
        $product->tags()->detach();
        $product->delete();
        return $product;
    }

    public function findProductBySlug(string $slug, int $pagination = null)
    {

        return $pagination ? $this->findBy(['slug' => $slug], $pagination) : $this->findBy(['slug' => $slug]);
    }

    public function decreaseQuantities(int $id, int $decrease = 1): bool
    {
        try {
            $product = $this->find($id);
            if ($product->quantity - $decrease < 0) return false;
            $product->update(['quantity' => $product->quantity - $decrease ]);
            return true;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }
}
