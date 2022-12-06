<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected string $model;
    protected Model $modelResolved;

    public function __construct()
    {
        $this->modelResolved = $this->resolveModel();
    }

    public function all()
    {
        return $this->modelResolved->all();
    }

    public function find(int $id)
    {
        return $this->modelResolved->find($id);
    }

    public function store(array $data)
    {
        return $this->modelResolved->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->modelResolved->find($id)->update($data);
    }

    public function delete(int $id): void
    {
        $this->modelResolved->find($id)->delete();
    }

    protected function resolveModel()
    {
        return app($this->model);
    }
}
