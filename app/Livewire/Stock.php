<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\StockService;
use App\Http\Controllers\ProductService;
use Mary\Traits\Toast;
use Carbon\Carbon;

class Stock extends Component
{
    use Toast;

    public $title = "Tipo de Produto";

    public $stockId;
    
    #[Validate('date|min(today)')]
    public $entrada;
    
    public $produtoId;

    #[Validate('integer:min(1)')]
    public $quantidade;

    public $stocks;

    public $products;
    
    public $is_creating = "false";
    public $is_editing = "false";
    public $show_table = True;

    public $busca = "";

    public $headers = [
        ['key'=> 'id', 'label' => '#'],
        ['key'=> 'entrada', 'label' => 'Entrada'],
        ['key'=> 'quantidade', 'label' => 'Quantidade'],
        ['key'=> 'produto', 'label' => 'Produto'],
        ['key'=> 'saldo', 'label' => 'Saldo'],
        ['key'=> 'actions', 'label' => 'Ações'],
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.stock');
    }

    public function getRecords()
    {
        if($this->busca == "")
        {
            $this->stocks = StockService::index();
        } else {
            $this->stocks = StockService::search($this->busca);
        }        
        $this->products = ProductService::index();
    }

    public function create()
    {
        $this->reset();
        $this->is_creating = true;
        $this->show_table = false;
    }

    public function save()
    {       
        $this->validate();        

        $data = [
            'nome'=> $this->nome, 
            'descricao' => $this->descricao,
            'codigo_barras' => $this->codigo_barras,
            'preco' => $this->preco,
            'produto_tipo_id' => $this->produto_tipo_id
        ];
        
        $request = new \Illuminate\Http\Request();

        $request->request->add($data);

        if(!isset($this->productId))
        {
            StockService::store($request);
        } else {
            StockService::update($request, $this->productId);
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
        $product = StockService::show($id);

        $this->productId = $product->id;
        $this->nome = $product->nome;
        $this->codigo_barras = $product->codigo_barras;
        $this->descricao = $product->descricao;
        $this->preco = $product->preco;
        $this->produto_tipo_id = $product->produto_tipo_id;

        $this->is_editing = true;
        $this->show_table = false;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function delete($id)
    {
        StockService::destroy($id);

        $this->toast(
            type:'danger',
            title: 'Registro excluído com sucesso!',
            position: 'toast-bottom toast-end',
            icon: 'o-information-circle',
            css: 'alert-danger',
            timeout: 3000,
            redirectTo: null
        );

        $this->reset();
    }
}
