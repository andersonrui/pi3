<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::get();
        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->nome = $request->nome;
        $customer->cpf = $request->cpf;
        $customer->endereco = $request->endereco;
        $customer->bairro = $request->bairro;
        $customer->cep = $request->cep;
        $customer->cidade = $request->cidade;
        $customer->telefone = $request->telefone;
        $customer->celular = $request->celular;
        $customer->ativo = $request->ativo;
        $customer->save();
        return response()->json($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);
        $customer->nome = $request->nome;
        $customer->cpf = $request->cpf;
        $customer->endereco = $request->endereco;
        $customer->bairro = $request->bairro;
        $customer->cep = $request->cep;
        $customer->cidade = $request->cidade;
        $customer->telefone = $request->telefone;
        $customer->celular = $request->celular;
        $customer->ativo = $request->ativo;
        $customer->save();
        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
