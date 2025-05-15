<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\ProductService;
use App\Http\Controllers\ProductTypeService;
use Mary\Traits\Toast;

class Product extends Component
{

    use Toast;

    public $title = "Tipo de Produto";

    public $productId;
    
    #[Validate('required|min:3')]
    public $nome;
    
    public $codigo_barras;

    public $descricao;

    #[Validate('required|decimal:0,2')]
    public $preco;

    #[Validate('required')]
    public $produto_tipo_id;

    public $products;

    public $productTypes;
    
    public $is_creating = "false";
    public $is_editing = "false";
    public $show_table = True;

    public $busca = "";

    public $headers = [
        ['key'=> 'id', 'label' => '#'],
        ['key'=> 'nome', 'label' => 'Categoria'],
        ['key'=> 'descricao', 'label' => 'Descrição'],
        ['key'=> 'preco', 'label' => 'Preço'],
        ['key' => 'produto_tipo_id', 'label' => 'Categoria'],
        ['key'=> 'actions', 'label' => 'Ações'],
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.product');
    }

    public function getRecords()
    {
        if($this->busca == "")
        {
            $this->products = ProductService::index();
        } else {
            $this->products = ProductService::search($this->busca);
        }        
        $this->productTypes = ProductTypeService::index();
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
            ProductService::store($request);
        } else {
            ProductService::update($request, $this->productId);
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
        $product = ProductService::show($id);

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
        ProductService::destroy($id);

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
