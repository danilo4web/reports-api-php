<?php

namespace App\Repositories\Eloquent;

use App\Entity\UserEntity;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected string $model = User::class;

    public function findByEmail(string $email): UserEntity
    {
        $user = $this->model::where('email', $email)->first();
        return UserEntity::fromArray($user->toArray());
    }

    public function getById(int $id): UserEntity
    {
        $userModel = $this->find($id);
        return UserEntity::fromArray($userModel->toArray());
    }

    public function createToken(UserEntity $userEntity): string
    {
        $userModel = $this->model::where('email', $userEntity->getEmail())->first();
        return $userModel->createToken("API TOKEN")->plainTextToken;
    }

    public function store(array $data): UserEntity
    {
        $userModel = parent::store($data);
        return UserEntity::fromArray($userModel->toArray());
    }

    public function update(int $id, array $data): UserEntity
    {
        return parent::find($id)->update($data);
        return UserEntity::fromArray($userModel->toArray());
    }
}
