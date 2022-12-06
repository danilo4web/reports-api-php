<?php

namespace App\Repositories\Contracts;

use App\Entity\UserEntity;

interface UserRepositoryInterface
{
    public function all();

    public function getById(int $id): UserEntity;

    public function store(array $data): UserEntity;

    public function update(int $id, array $data): UserEntity;

    public function delete(int $id): void;

    public function findByEmail(string $email): UserEntity;

    public function createToken(UserEntity $userEntity): string;
}
