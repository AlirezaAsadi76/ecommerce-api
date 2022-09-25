<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model=$model;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return $this->find($id)->update($attributes);
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc', $columns = ['*'], int $pagination = null)
    {
        return $pagination ?
            $this->model->orderBy($orderBy,$sortBy)->select($columns)->paginate($pagination) : $this->model->orderBy($orderBy,$sortBy)->get($columns);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOneOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(array $data, int $pagination = null)
    {
        return $pagination ? $this->model->where($data)?->paginate($pagination) : $this->model->where($data)?->first();
    }

    public function findOneBy(array $data)
    {
        return $this->model->where($data)?->first();
    }

    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }
}
