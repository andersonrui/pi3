<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class StockService extends Controller
{
 /**
     * Display a listing of the resource.
     */
    public static function index()
    {
        $stocks = Stock::with(['produto'])->get();
        
        return $stocks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store(Request $request)
    {
        $stock = new Stock();
        $stock->produto_id = $request->get('produto_id');
        $stock->quantidade = $request->get('quantidade');
        $stock->entrada = $request->get('entrada');
        $stock->save();
        return $stock;
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        $stock = Stock::find($id);
        return $stock;
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(Request $request, string $id)
    {
        $stock = Stock::find($id);
        $stock->produto_id = $request->get('produto_id');
        $stock->quantidade = $request->get('quantidade');
        $stock->entrada = $request->get('entrada');
        $stock->save();
        return $stock;
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $id)
    {
        Stock::destroy($id);
    }

    public static function search($value)
    {
        // $products = Stock::where('nome', 'like', "%$value%")
        //     ->orWhere('descricao', 'like', "%$value%")
        //     ->get();

        // return $products;
    }

    public static function getAvailableProducts()
    {
        $stock = Stock::selectRaw('produto_id, SUM(quantidade) as estoque')
            ->groupBy('produto_id')
            ->get();

        $ids = [];

        $stock_filtered = array_column(array_filter($stock->toArray(), function($record){
            if($record['estoque'] > 0){
                return $record;
            }
        }), 'produto_id');

        $products = Product::select('*')->whereIn('id', $stock_filtered)->get();

        return $products;
    }
}
