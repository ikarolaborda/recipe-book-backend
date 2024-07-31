<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BaseServiceInterface
{
    /** Here we Define All Common CRUD Methods with return types */
    public function all(): array | Collection;
    public function create(array $data): object;
    public function find(int $id): ?object;
    public function update(array $data, int $id): ?object;
    public function delete(int $id): void;
}
