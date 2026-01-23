<?php

namespace App\Services;

use App\Repositories\FactoriesRepository;
use App\Repositories\Interface\FactoriesRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class FactoriesService
{
    public function __construct(protected FactoriesRepositoryInterface $repository)
    {
    }

    public function all()
    {
        try {

            return $this->repository->all();

        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function find($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function create($request)
    {
        try {
            $path = $request->file('image')->store('logo', 'public');

            $data = [
                'user_id' => 1,
                'name' => $request->name,
                'logo_image' => $path,
                'motto' => $request->motto,
            ];

            return $this->repository->create($data);

        } catch (\Exception $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function update($request, $id)
    {
        try {
            $factory = $this->find($id);

            $data = $request->only(['name', 'motto', 'user_id']);

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($factory->logo_image);
                $data['image'] = $request->file('image')->store('logo', 'public');
            }

            if(!$data){
                return [
                    'error' => true,
                    'message' => "yangi o'zgarishlar yo'q"
                ];
            }

            return $this->repository->update($factory, $data);

        } catch (\Exception $e) {

            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $factory = $this->find($id);
            if ($factory) {
                Storage::disk('public')->delete($factory->logo_image);
                $this->repository->delete($factory);
            }

            return null;
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
