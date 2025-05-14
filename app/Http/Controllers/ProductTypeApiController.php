<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductTypeService;

class ProductTypeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $productTypes = ProductTypeService::index();
        return response()->json($productTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $productType = ProductTypeService::store($request);
        return response()->json($productType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productType = ProductTypeService::show($id);
        return response()->json($productType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productType = ProductTypeService::update($request, $id);

        return response()->json($productType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductTypeService::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
