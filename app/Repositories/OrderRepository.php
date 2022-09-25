<?php

namespace App\Repositories;

use App\Contracts\OrderContracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class OrderRepository extends BaseRepository implements OrderContracts
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model=$model;
    }

    public function listOrders(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null)
    {
        return $pagination ? $this->all($orderBy, $sortBy, $columns, $pagination) : $this->all($orderBy, $sortBy, $columns);
    }

    public function findOrderById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function createOrder(array $attributes)
    {
        try {
            return $this->create($attributes);
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function updateOrder(int $id, array $attributes)
    {
        try {
            $order = $this->findOrderById($id);
            $order->update($attributes);
            return $order;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function deleteOrder(int $id)
    {
        $category = $this->findOrderById($id);
        $category->delete();
        return $category;
    }
}
