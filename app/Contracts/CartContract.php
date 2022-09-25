<?php

namespace App\Contracts;

interface CartContract
{
    public function listCarts(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null);
    public function findCartById(int $id);
    public function findCartByUser(int $userId);
    public function createCart(array $attributes);
    public function updateCart(int $id, array $attributes);
    public function deleteCart(int $id);
    public function updateOrCreateCartItem(int $cartId, array $attributes);
    public function deleteCartItem(int $cartId, array $attributes);

}
