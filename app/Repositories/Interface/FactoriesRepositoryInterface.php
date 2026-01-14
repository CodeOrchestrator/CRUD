<?php

namespace App\Repositories\Interface;

use App\Models\Factory;

interface FactoriesRepositoryInterface
{
    public function all();

    public function find(int $id): ?Factory;

    public function create(array $data):Factory;

    public function update(Factory $factory, array $data): bool;

    public function delete(Factory $factory): bool;
}
