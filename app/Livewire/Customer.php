<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Http\Controllers\CustomerService;
use Mary\Traits\Toast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Customer extends Component
{
    use Toast;

    public $title = "Cliente";

    public $clienteId;

    #[Validate('required')]
    public $nome;

    #[Validate('required|size:14')]
    public $cpf;

    #[Validate('required')]
    public $endereco;

    #[Validate('required')]
    public $bairro;

    #[Validate('required')]
    public $cep;

    #[Validate('required')]
    public $cidade;

    public $telefone;

    public $celular;

    public $ativo;

    public $customers;  
    
    public $is_creating = "false";
    public $is_editing = "false";
    public $show_table = True;

    public $busca = "";

    public $headers = [
        ['key'=> 'id', 'label' => '#'],
        ['key'=> 'nome', 'label' => 'Nome'],
        ['key'=> 'telefone', 'label' => 'telefone'],
        ['key'=> 'celular', 'label' => 'Celular'],
        ['key'=> 'ativo', 'label' => 'ativo'],
        ['key'=> 'actions', 'label' => 'Ações'],
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.customer');
    }

    public function getRecords()
    {
        if($this->busca == "")
        {
            $this->customers = CustomerService::index();
        } else {
            $this->stocks = CustomerService::search($this->busca);
        }        
        $this->products = CustomerService::index();
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
            'cpf' => $this->cpf,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'cep' => $this->cep,
            'cidade' => $this->cidade,
            'telefone' => $this->telefone,
            'celular' => $this->celular,
            'ativo' => $this->ativo
        ];
        
        $request = new \Illuminate\Http\Request();

        $request->request->add($data);

        if(!isset($this->clienteId))
        {
            CustomerService::store($request);
        } else {
            CustomerService::update($request, $this->clienteId);
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

        $cliente = CustomerService::show($id);

        $this->clienteId = $cliente->id;
        $this->nome = $cliente->nome;
        $this->cpf = $cliente->cpf;
        $this->endereco = $cliente->endereco;
        $this->bairro = $cliente->bairro;
        $this->cep = $cliente->cep;
        $this->cidade = $cliente->cidade;
        $this->telefone = $cliente->telefone;
        $this->celular = $cliente->celular;
        $this->ativo = (bool)$cliente->ativo;
        
        $this->is_editing = true;
        $this->show_table = false;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function delete($id)
    {
        CustomerService::destroy($id);

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

    public function updatedCep()
    {
        $dados = Http::get("viacep.com.br/ws/$this->cep/json/");

        $cep = json_decode($dados->body(), true);

        if($dados->status()==200)
        {
            $this->endereco = $cep['logradouro'];
            $this->bairro = $cep['bairro'];
            $this->cidade = $cep['localidade'];
        }
    }
}
