<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTypes = ProductType::get();
        return response()->json($productTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $productType = new ProductType();
        $productType->name = $request->name;
        $productType->active = True;
        $productType->save();
        return response()->json($productType);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productType = ProductType::find($id);
        return response()->json($productType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $productType = ProductType::find($id);
        $productType->name = $request->name;
        $productType->active = $request->active;
        $productType->save();
        return response()->json($productType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductType::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
