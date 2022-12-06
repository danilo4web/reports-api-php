<?php

namespace App\Repositories\Eloquent;

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
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id): void
    {
        return $this->model->find($id)->delete();
    }

    protected function resolveModel()
    {
        return app($this->model);
    }
}
