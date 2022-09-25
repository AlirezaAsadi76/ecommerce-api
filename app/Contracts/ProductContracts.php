<?php

namespace App\Contracts;

interface ProductContracts
{
    public function listProducts(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null);
    public function findProductById(int $id);
    public function createProduct(array $attributes);
    public function updateProduct(int $id, array $attributes);
    public function deleteProduct(int $id);
    public function findProductBySlug(string $slug, int $pagination = null);
    public function decreaseQuantities(int $id, int $decrease = 1): bool;
}
