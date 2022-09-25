<?php

namespace App\Contracts;

interface OrderContracts
{
    public function listOrders(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null);
    public function findOrderById(int $id);
    public function createOrder(array $attributes);
    public function updateOrder(int $id, array $attributes);
    public function deleteOrder(int $id);
}
