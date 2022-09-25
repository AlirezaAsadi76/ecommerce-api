<?php

namespace App\Contracts;

interface BaseContract
{
    public function create(array $attributes);
    public function update(int $id, array $attributes);
    public function delete(int $id);
    public function all(string $orderBy = 'id', string $sortBy = 'desc', $columns = ['*'], int $pagination = null);
    public function find(int $id);
    public function findOneOrFail(int $id);
    public function findBy(array $data, int $pagination = null);
    public function findOneBy(array $data);
    public function findOneByOrFail(array $data);

}
