<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductService extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        $products = Product::with(['tipoProduto'])->get();
        
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store(Request $request)
    {
        $product = new Product();
        $product->nome = $request->get('nome');
        $product->codigo_barras = $request->get('codigo_barras');
        $product->descricao = $request->get('descricao');
        $product->preco = $request->get('preco');
        $product->produto_tipo_id = $request->get('produto_tipo_id');
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        $product = Product::find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->nome = $request->get('nome');
        $product->codigo_barras = $request->get('codigo_barras');
        $product->descricao = $request->get('descricao');
        $product->preco = $request->get('preco');
        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $id)
    {
        Product::destroy($id);
    }

    public static function search($value)
    {
        $products = Product::where('nome', 'like', "%$value%")
            ->orWhere('descricao', 'like', "%$value%")
            ->get();

        return $products;
    }
}
