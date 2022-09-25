<?php

namespace App\Contracts;

interface CategoryContracts
{
    public function listCategories(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null);
    public function findCategoryById(int $id);
    public function createCategory(array $attributes);
    public function updateCategory(int $id, array $attributes);
    public function deleteCategory(int $id);
    public function findCategoryBySlug(string $slug, int $pagination = null);
}
