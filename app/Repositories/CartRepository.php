<?php

namespace App\Repositories;

use App\Contracts\CartContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;
class CartRepository extends BaseRepository implements CartContract
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function listCarts(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null)
    {
        return $pagination ? $this->all($orderBy, $sortBy, $columns, $pagination) : $this->all($orderBy, $sortBy, $columns);
    }

    public function findCartById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function findCartByUser(int $userId)
    {
        try {
            return $this->findBy(['user_id' => $userId]);
        } catch (ModelNotFoundException $error) {
            throw new ModelNotFoundException($error);
        }
    }

    public function createCart(array $attributes)
    {
        try {
            return $this->create($attributes);
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function updateCart(int $id, array $attributes)
    {
        try {
            $cart = $this->findCartById($id);
            return $cart->update($attributes);
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function deleteCart(int $id)
    {
        $cart = $this->findCartById($id);
        $cart->delete();
        return $cart;
    }

    public function updateOrCreateCartItem(int $cartId, array $attributes)
    {
        try {
            $cart = $this->findCartById($cartId);
            $cart->items()->updateOrCreate(
                ['cart_id' => $cartId, 'product_id' => $attributes['product_id']],
                ['quantity' => $attributes['quantity'], 'price' => $attributes['price']]
            );
            return $cart;
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }

    public function deleteCartItem(int $cartId, array $attributes)
    {
        try {
            $cart = $this->findCartById($cartId);
            return $cart->items()->where($attributes)->first()->delete();
        } catch (QueryException $error) {
            throw new InvalidArgumentException($error->getMessage());
        }
    }
}
