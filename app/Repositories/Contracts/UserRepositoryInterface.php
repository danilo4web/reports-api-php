<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function store(array $data): UserEntity;

    public function update(int $id, array $data): UserEntity;

    public function delete(int $id): void;

    public function findByEmail(string $email): UserEntity;

    public function createToken(UserEntity $userEntity): string;
}
