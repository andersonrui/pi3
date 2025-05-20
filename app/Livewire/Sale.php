<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\SaleService;
use App\Http\Controllers\StockService;
use App\Http\Controllers\ProductService;
use App\Http\Controllers\CustomerService;
use App\Models\ProductSale;
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
    
    public $products_sale_headers = [
        ['key' => 'key', 'label' => 'index', 'class' => 'hidden'], 
        ['key' => 'produto_id', 'label' => '#'],
        ['key' => 'quantidade', 'label' => 'quantidade'],
        ['key' => 'valor_unitario', 'label' => 'unitario'],
        ['key' => 'total', 'label' => 'total'],
        ['key' => 'desconto', 'label' => 'desconto'],
        ['key' => 'actions', 'label' => 'Ações']
    ];

    public $bag_produto_id;
    public $bag_quantidade;
    public $bag_valor_unitario;
    public $bag_total;
    public $bag_desconto;
    
    public $is_creating = false;
    public $is_editing = false;
    public $is_adding_product = false;
    public $show_table = true;

    public $busca = "";

    public $headers = [
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
        $this->data = Carbon::now();
    }

    public function save()
    {

        if(sizeof($this->products_sale) == 0)
        {
            $this->toast(
                type:'error',
                title: 'É necessário adicionar itens à venda!',
                position: 'toast-middle toast-center',
                icon: 'o-information-circle',
                css: 'alert-error',
                timeout: 3000,
                redirectTo: null
            );

            return;
        }

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
            $sale = SaleService::store($request);
        } else {
            $sale = SaleService::update($request, $this->saleId);
        }

        foreach($this->products_sale as $product){
            $productSale = new ProductSale();
            $productSale->venda_id = $sale->id;
            $productSale->produto_id = $product['produto_id'];
            $productSale->quantidade = $product['quantidade'];
            $productSale->valor_unitario = $product['valor_unitario'];
            $productSale->desconto = $product['desconto'];
            $productSale->save();
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

        $produtos = SaleService::show($id)->produtos()->get();

        $this->products_sale = $produtos->toArray();

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

    public function adicionarProduto()
    {
        $this->is_adding_product = true;
    }

    public function add_to_bag()
    {

        $key = array_search($this->bag_produto_id, array_column($this->products_sale, 'produto_id', $this->bag_produto_id));

        if($key === false) {
            $data = [
                'produto_id' => $this->bag_produto_id,
                'quantidade' => $this->bag_quantidade,
                'valor_unitario' => $this->bag_valor_unitario,
                'total' => $this->bag_total,
                'desconto' => $this->bag_desconto
            ];

            array_push($this->products_sale, $data);
        } else {
             $this->products_sale[$key]['produto_id'] = $this->bag_produto_id;
             $this->products_sale[$key]['quantidade'] = $this->bag_quantidade;
             $this->products_sale[$key]['valor_unitario'] = $this->bag_valor_unitario;
             $this->products_sale[$key]['total'] = $this->bag_total;
             $this->products_sale[$key]['desconto'] = $this->bag_desconto;
        }

        

        $this->is_adding_product = false;
        $this->bag_produto_id = null;
        $this->bag_quantidade = null;
        $this->bag_valor_unitario = null;
        $this->bag_total = null;
        $this->bag_desconto = null;
        
        $valorTotal = 0;

        foreach($this->products_sale as $product)
        {
            $valorTotal += $product['total'];
        }

        $this->valorTotal = $valorTotal;
    }

    public function editBag($produto_id)
    {
        $key = array_search($produto_id, array_column($this->products_sale, 'produto_id', $produto_id));

        $this->bag_produto_id = $this->products_sale[$key]['produto_id'];
        $this->bag_quantidade = $this->products_sale[$key]['quantidade'];
        $this->bag_valor_unitario = $this->products_sale[$key]['valor_unitario'];
        $this->bag_desconto = $this->products_sale[$key]['desconto'];

        $this->is_adding_product = true;
    }

    public function calculaValorProduto()
    {
        if($this->bag_quantidade != 0 && $this->bag_produto_id != "" && $this->bag_valor_unitario != 0){
            if($this->bag_desconto != 0 && $this->bag_desconto != ""){
                $this->bag_total = round($this->bag_quantidade * ($this->bag_valor_unitario * ((($this->bag_desconto/100)-1)*-1)), 2);
            } else {
                $this->bag_total = $this->bag_valor_unitario * $this->bag_quantidade;
            }
        }
    }

    public function getValorUnitario()
    {
        if($this->bag_produto_id != null){
            $id = $this->bag_produto_id;
            $produto = ProductService::show($id);

            $this->bag_valor_unitario = $produto->preco;
        }
    }

    public function cancel()
    {
        $this->reset();
    }
}
