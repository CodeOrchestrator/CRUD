<?php

namespace App\Repositories;

use App\Models\Factory;
use App\Models\Product;
use App\Repositories\Interface\FactoriesRepositoryInterface;

class FactoriesRepository implements FactoriesRepositoryInterface
{

    public function __construct(protected Factory $factory)
    {
    }

    public function all()
    {
        return $this->factory->get();
    }

    public function find(int $id): ?Factory
    {
        return $this->factory->find($id);
    }

    public function create(array $data): Factory
    {
        return $this->factory->create($data);
    }

    public function update(Factory $factory,array $data): bool
    {
        return $factory->update($data);
    }

    public function delete(Factory $factory): bool
    {
        return $factory->delete();
    }
}
