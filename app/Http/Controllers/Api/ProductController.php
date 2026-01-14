<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductsService $service)
    {
    }

    public function index()
    {
        $products = $this->service->all();
        if (isset($products['error'])) {
            return response()->json(['success' => true, 'error' => $products['message']],200);
        }

        return response()->json(['success' => true, 'data' => $products],200);
    }

    public function show($id)
    {
        $product = $this->service->find($id);
        if (isset($product['error'])) {
            return response()->json(['success' => false, 'error' => $product['message']],200);
        }

        return response()->json(['success' => true, 'data' => $product],200);
    }

    public function create(CreateRequest $request)
    {
        $product = $this->service->create($request);

        if (isset($product['error'])) {
            return response()->json(['success' => false, 'error' => $product['message']],200);
        }

        return response()->json(['success' => true, 'data' => $product],200);
    }

    public function update(UpdateRequest $request, $id){

        $product = $this->service->update($request, $id);

        if (isset($product['error'])) {
            return response()->json(['success' => false, 'error' => $product['message']],200);
        }

        return response()->json(['success' => true, 'data' => $product],200);
    }

    public function delete($id){
        $product = $this->service->delete($id);
        if (isset($product['error'])) {
            return response()->json(['success' => false, 'error' => $product['message']],200);
        }
        return response()->json(['success' => true, 'data' => $product],200);
    }

}
