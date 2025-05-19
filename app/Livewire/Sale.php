<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\SaleService;
use App\Http\Controllers\StockService;
use App\Http\Controllers\ProductService;
use App\Http\Controllers\CustomerService;
use Mary\Traits\Toast;
use Carbon\Carbon;

class Sale extends Component
{

    use Toast;

    public $title = "Vendas";

    public $sales;

    public $customers;

    public $saleId;

    #[Validate('required')]
    public $clienteId;  

    public $produtos;
    
    #[Validate('required')]
    public $data;

    #[Validate('required')]
    public $valorTotal;

    public $desconto;

    public $pago;
    
    public $products;

    public $products_sale = [];
    
    public $is_creating = true;
    public $is_editing = false;
    public $show_table = false;

    public $busca = "";

    public $headers = [
        ['key'=> 'id', 'label' => '#'],
        ['key'=> 'data', 'label' => 'Data'],
        ['key'=> 'cliente_id', 'label' => 'Cliente'],
        ['key'=> 'valor_total', 'label' => 'Valor Total'],
        ['key'=> 'pago', 'label' => 'Pago'],
        ['key'=> 'actions', 'label' => 'Ações'],
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.sale');
    }

    public function getRecords()
    {   
        $this->sales = SaleService::index();
        $this->customers = CustomerService::index();
        $this->products = StockService::getAvailableProducts();
    }

    public function create()
    {
        $this->reset();
        $this->is_creating = true;
        $this->is_editing = false;
        $this->show_table = false;
    }

    public function save()
    {
        $this->validate();        

        $data = [
            'data'=> $this->data, 
            'cliente_id' => $this->clienteId,
            'valor_total' => $this->valorTotal,
            'desconto' => $this->desconto,
            'pago' => $this->pago
        ];
        
        $request = new \Illuminate\Http\Request();

        $request->request->add($data);

        if(!isset($this->saleId))
        {
            SaleService::store($request);
        } else {
            SaleService::update($request, $this->saleId);
        }

        $this->toast(
            type:'success',
            title: 'Registro salvo com sucesso!',
            position: 'toast-bottom toast-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: null
        );

        $this->reset();
    }

    public function edit($id)
    {

        $this->reset();

        $sale = SaleService::show($id);

        $this->saleId = $sale->id;

        $this->data = $sale->data;
        $this->clienteId = $sale->cliente_id;
        $this->valorTotal = $sale->valor_total;
        $this->desconto = $sale->desconto;
        $this->pago = (bool)$sale->pago;

        $this->is_editing = true;
        $this->show_table = false;
    }

    public function delete($id)
    {

        SaleService::destroy($id);

        $this->toast(
            type:'success',
            title: 'Registro excluído com sucesso!',
            position: 'toast-bottom toast-end',
            icon: 'o-information-circle',
            css: 'alert-info',
            timeout: 3000,
            redirectTo: null
        );

        $this->reset();
    }
}
