<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\ProductTypeService;
use Mary\Traits\Toast;

class ProductType extends Component
{

    use Toast;

    public $title = "Tipo de Produto";

    public $productTypeId;
    
    #[Validate('required|min:3')]
    public $nome;
    
    public $ativo;

    public $productTypes;
    
    public $is_creating = "false";
    public $is_editing = "false";
    public $show_table = True;

    public $busca = "";

    public $headers = [
        ['key'=> 'id', 'label' => '#'],
        ['key'=> 'nome', 'label' => 'Categoria'],
        ['key'=> 'actions', 'label' => 'Ações'],
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.product-type');
    }

    public function getRecords()
    {
        if($this->busca == "")
        {
            $this->productTypes = ProductTypeService::index();
        } else {
            $this->productTypes = ProductTypeService::search($this->busca);
        }        
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

        $data = ['nome'=> $this->nome, 'ativo' => ($this->ativo)? true : false];
        
        $request = new \Illuminate\Http\Request();

        $request->request->add($data);

        if(!isset($this->productTypeId))
        {
            ProductTypeService::store($request);
        } else {
            ProductTypeService::update($request, $this->productTypeId);
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
        $productType = ProductTypeService::show($id);

        $this->productTypeId = $productType->id;
        $this->nome = $productType->nome;
        $this->ativo = (bool)($productType->ativo);

        $this->is_editing = true;
        $this->show_table = false;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function delete($id)
    {
        ProductTypeService::destroy($id);

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
