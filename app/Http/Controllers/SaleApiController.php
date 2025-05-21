<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SaleService;

class SaleApiController extends Controller
{
    public function index(){
        $sales = SaleService::index();
        return $sales;
    }

    public function store(Request $request){
        $sale = SaleService::store($request);
        return $sale;
    }

    public function show($id)
    {
        $sale = SaleService::show($id);
        return $sale;
    }

    public function update(Request $request, $id){
        $sale = SaleService::update($request, $id);
        return $sale;
    }

    public function destroy($id){
        SaleService::destroy($id);
    }

    public function aVencer()
    {
        $sale = Sale::aVencer();
        return $sale->aVencer();
    }
}
