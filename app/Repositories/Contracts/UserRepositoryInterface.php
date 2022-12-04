<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function store(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
