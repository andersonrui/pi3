<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\StockApiController;

class StockApiController extends Controller
{
     public static function index(){
        $sales = SaleService::index();
        return $sales;
    }

    public static function store(Request $request)
    {
        $stock = StockService::store($request);
        return $stock;
    }

    /**
     * Display the specified resource.
     */
    public static function show(string $id)
    {
        $stock = StockService::find($id);
        return $stock;
    }

    /**
     * Update the specified resource in storage.
     */
    public static function update(Request $request, string $id)
    {
        $stock = StockService::update($request, $id);
        return $stock;
    }

    /**
     * Remove the specified resource from storage.
     */
    public static function destroy(string $id)
    {
        StockService::destroy($id);
    }

    public static function getAvailableProducts()
    {
        $stock = StockService::getAvailableProducts();
        return $stock;
    }
}
