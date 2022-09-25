<?php

namespace App\Repositories;

use App\Contracts\TagContracts;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class TagRepository extends BaseRepository implements TagContracts
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }
    public function listTags(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null)
    {
        return $pagination ? $this->all($orderBy, $sortBy, $columns, $pagination) : $this->all($orderBy, $sortBy, $columns);
    }

    public function findTagById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function createTag(array $attributes)
    {
        try {
            return $this->create($attributes);
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function updateTag(int $id, array $attributes)
    {
        try {
            $tag = $this->findTagById($id);
            $tag->update($attributes);
            return $tag;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function deleteTag(int $id)
    {
        $tag = $this->findTagById($id);
        $tag->delete();

        return $tag;
    }

    public function findTagBySlug(string $slug, int $pagination = null)
    {
        return $pagination ? $this->findBy(['slug' => $slug], $pagination) : $this->findBy(['slug' => $slug]);
    }
}
