<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Factory\CreateRequest;
use App\Http\Requests\Factory\UpdateRequest;
use App\Services\FactoriesService;

class FactoryController extends Controller
{
    public function __construct(protected FactoriesService $service)
    {
    }

    public function index()
    {
        $factories = $this->service->all();
        if (isset($factory['error'])) {
            return response()->json(['success' => true, 'error' => $factories['message']],200);
        }

        return response()->json(['success' => true, 'data' => $factories],200);
    }

    public function show($id)
    {
        $factory = $this->service->find($id);
        if (isset($factory['error'])) {
            return response()->json(['success' => false, 'error' => $factory['message']],200);
        }

        return response()->json(['success' => true, 'data' => $factory],200);
    }

    public function create(CreateRequest $request)
    {
        $factory = $this->service->create($request);

        if (isset($factory['error'])) {
            return response()->json(['success' => false, 'error' => $factory['message']],200);
        }

        return response()->json(['success' => true, 'data' => $factory],200);
    }

    public function update(UpdateRequest $request, $id){

        $factory = $this->service->update($request, $id);

        if (isset($factory['error'])) {
            return response()->json(['success' => false, 'error' => $factory['message']],200);
        }

        return response()->json(['success' => true, 'data' => $factory],200);
    }

    public function delete($id){
        $factory = $this->service->delete($id);

        if ($factory == null){
            return response()->json([
                'success' => false,
                'error' => 'bazada mavjud emas'
            ],200);
        }
        if (isset($factory['error'])) {
            return response()->json(['success' => false, 'error' => $factory['message']],200);
        }
        return response()->json(['success' => true, 'data' => $factory],200);
    }
}
