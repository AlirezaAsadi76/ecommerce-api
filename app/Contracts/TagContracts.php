<?php

namespace App\Contracts;

interface TagContracts
{
    public function listTags(string $orderBy = 'id', string $sortBy = 'desc', array $columns = ['*'], int $pagination = null);
    public function findTagById(int $id);
    public function createTag(array $attributes);
    public function updateTag(int $id, array $attributes);
    public function deleteTag(int $id);
    public function findTagBySlug(string $slug, int $pagination = null);
}
