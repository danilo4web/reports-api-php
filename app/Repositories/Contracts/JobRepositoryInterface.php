<?php

namespace App\Repositories\Contracts;

interface JobRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function store(array $data);

    public function update(int $id, array $data);
}
