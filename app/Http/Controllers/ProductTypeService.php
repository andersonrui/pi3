<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeService
{
    /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        $productTypes = ProductType::get();

        return $productTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store(Request $request)
    {
        $productType = new ProductType();
        $productType->nome = $request->get('nome');
        $productType->ativo = $request->get('ativo');
        $productType->save();

        return $productType;
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        $productType = ProductType::find($id);
        return $productType;
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(Request $request, string $id)
    {
        $productType = ProductType::find($id);
        $productType->nome = $request->get('nome');
        $productType->ativo = $request->get('ativo');
        $productType->save();
        return $productType;
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $id)
    {
        ProductType::destroy($id);
    }

    public static function search($value)
    {
        $productTypes = ProductType::where('nome', 'like', "%$value%");

        return $productTypes->get();
    }
}
