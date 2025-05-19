<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class SaleService extends Controller
{
    public static function index(){
        $sales = Sale::with('cliente')->get();
        return $sales;
    }

    public static function store(Request $request){
        $sale = new Sale();
        $sale->data = $request->get('data');
        $sale->valor_total = $request->get('valor_total');
        $sale->cliente_id = $request->get('cliente_id');
        $sale->pago = $request->get('pago');
        $sale->desconto = $request->get('desconto');
        
        if(!$request->get('vencimento'))
        {
            $sale->vencimento = Carbon::now();
        } else {
            $sale->vencimento = $request->get('vencimento');
        }

        $sale->save();

        return $sale;
    }

    public static function show($id)
    {
        $sale = Sale::find($id);

        return $sale;
    }

    public static function update(Request $request, $id){
        $sale = Sale::find($id);

        $sale->data = $request->get('data');
        $sale->valor_total = $request->get('valor_total');
        $sale->cliente_id = $request->get('cliente_id');
        $sale->pago = $request->get('pago');
        $sale->desconto = $request->get('desconto');
        
        if(!$request->get('vencimento'))
        {
            $sale->vencimento = Carbon::now();
        } else {
            $sale->vencimento = $request->get('vencimento');
        }

        $sale->save();

        return $sale;
    }

    public static function destroy($id){
        Sale::destroy($id);
    }

    public static function aVencer()
    {
        $sale = new Sale();
        return $sale->aVencer();
    }
}
