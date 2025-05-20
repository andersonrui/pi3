<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;
use Carbon\Carbon;

class Dashboard extends Component
{

    public $late_sales;

    public $due_sales;

    public $last_sales;

    public $headers_last_sales = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'data', 'label' => 'Data'],
        ['key' => 'cliente_id', 'label' => 'Cliente_ID'],
        ['key' => 'valor_total', 'label' => 'Total']
    ];

    public $headers_late_sales = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'data', 'label' => 'Data'],
        ['key' => 'vencimento', 'label' => 'Vencimento'],
        ['key' => 'cliente_id', 'label' => 'Cliente_ID'],
        ['key' => 'valor_total', 'label' => 'Total']
    ];

    public $headers_due_sales = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'data', 'label' => 'Data'],
        ['key' => 'vencimento', 'label' => 'Vencimento'],
        ['key' => 'cliente_id', 'label' => 'Cliente_ID'],
        ['key' => 'valor_total', 'label' => 'Total']
    ];

    public function render()
    {
        $this->getRecords();
        return view('livewire.dashboard');
    }

    public function getRecords()
    {
        $this->last_sales = Sale::orderBy('data', 'desc')->with(['cliente'])->take(10)->get();

        $this->late_sales = Sale::where('vencimento', '<', Carbon::now())->where('pago', 0)->get();

        $this->due_sales = Sale::where('vencimento', '>=', Carbon::now())->where('pago', 0)->get();
    }

}
