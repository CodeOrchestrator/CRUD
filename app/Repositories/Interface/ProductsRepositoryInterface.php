<?php

namespace App\Repositories\Interface;

use App\Models\Product;

interface ProductsRepositoryInterface
{
    public function all();

    public function find(int $id): ?Product;
    public function create(array $data): Product;
    public function update(Product $product, array $data): bool;
    public function delete(Product $product): bool;
}
