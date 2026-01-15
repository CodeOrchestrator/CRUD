<?php

namespace App\Services;

use App\Repositories\Interface\ProductsRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProductsService
{
    public function __construct(protected ProductsRepositoryInterface $repository)
    {
    }

    public function all()
    {
        try {
            return $this->repository->all();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function find(int $id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function create($request)
    {
        try {
            $path = Storage::disk('public')->put('products', $request->image);
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path,
                'factory_id' => $request->factory_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ];

            return $this->repository->create($data);

        } catch (\Exception $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update($request, $id)
    {
        try {
            $product = $this->find($id);

            $data = $request->only(['name', 'description', 'price', 'quantity', 'factory_id']);

            if ($request->hasFile('image')) {
                $path = Storage::disk('public')->put('products', $request->image);
                $data['image'] = $path;
            }

            if (!$data) {
                return [
                    'error' => true,
                    'message' => 'yangilanish mavjud emas'
                ];
            }

            return $this->repository->update($product, $data);

        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $product = $this->repository->find($id);

            if ($product) {
                Storage::disk('public')->delete($product->image);
                $this->repository->delete($product);
            }

        }catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
