<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerService extends Controller
{
    public static function index()
    {
        $customers = Customer::get();
        return $customers;
    }

    public static function store(Request $request)
    {
        $customer = new Customer();
        $customer->nome = $request->get('nome');
        $customer->cpf = $request->get('cpf');
        $customer->endereco = $request->get('endereco');
        $customer->bairro = $request->get('bairro');
        $customer->cep = $request->get('cep');
        $customer->cidade = $request->get('cidade');
        $customer->telefone = $request->get('telefone');
        $customer->celular = $request->get('celular');
        $customer->ativo = $request->get('ativo');
        $customer->save();
        return $customer;
    }

    public static function show($id)
    {
        $customer = Customer::find($id);
        return $customer;
    }

    public static function update($request, $id)
    {
        $customer = Customer::find($id);

        $customer->nome = $request->get('nome');
        $customer->cpf = $request->get('cpf');
        $customer->endereco = $request->get('endereco');
        $customer->bairro = $request->get('bairro');
        $customer->cep = $request->get('cep');
        $customer->cidade = $request->get('cidade');
        $customer->telefone = $request->get('telefone');
        $customer->celular = $request->get('celular');
        $customer->ativo = $request->get('ativo');
        $customer->save();
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::destroy($id);
    }

}
