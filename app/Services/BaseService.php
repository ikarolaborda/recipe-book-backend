<?php

namespace App\Services;

use App\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Model $model
    )
    {}

    public function all(): array|Collection
    {
        return $this->model->all();
    }

    public function create(array $data): object
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?object
    {
        return $this->model->find($id);
    }

    public function update(array $data, int $id): ?object
    {
        $model = $this->model->find($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): void
    {
        $this->model->destroy($id);
    }


}
