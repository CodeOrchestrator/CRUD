<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductsRepositoryInterface;

class ProductsRepository implements ProductsRepositoryInterface
{
    public function __construct(protected Product $product)
    {
    }

    public function all()
    {
        return $this->product->get();
    }

    public function find(int $id): ?Product
    {
        return $this->product->find($id);
    }

    public function create(array $data): Product
    {
        return $this->product->create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
