<div>
    <h2>{{ $title }}</h2>
    <div wire:show="show_table">
        <div class="grid grid-cols-12">
            <div class="col-span-6">
                <x-input label="Busca" wire:model="busca" wire:change='getRecords' />
            </div>
            <div class="ml-14 mt-10 col-span-4">
                <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="create" spinner>Nova Venda</x-button>
            </div>
        </div>
        <x-table :headers="$headers" :rows="$sales" striped>
            @scope('cell_valor_total', $sale)
                {{ number_format($sale->valor_total, 2, ',', '.') }}
            @endscope
            @scope('cell_cliente_id', $sale)
                {{ $sale->cliente->nome }}
            @endscope
            @scope('cell_pago', $sale)
                {{ ($sale->pago) ? 'Sim' : 'Não' }}
            @endscope
            @scope('cell_actions', $sale)
                <x-button icon="o-pencil" class="btn-sm" wire:click="edit({{ $sale->id }})" spinner />
                <x-button icon="o-trash" class="btn-sm" wire:click="delete({{ $sale->id }})" spinner
                    wire:confirm="Deseja realmente excluir o registro selecionado?" />
            @endscope
        </x-table>
    </div>

    <div wire:show="show_table==false">
        <x-form wire:submit="save">
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-2/3">
                    <x-input wire:model="saleId" class="hidden" />
                    <x-input wire:model="data" type="date" label="Data da Venda"/>
                    <x-input wire:model="valorTotal" label="Valor Total" />
                    <x-input wire:model="desconto" label="Desconto" />
                    <x-toggle wire:model="pago" label="Pago" />
                    <x-choices-offline label="Cliente" wire:model="clienteId" :options="$customers" option-label="nome" placeholder="Selecione o cliente..." single searchable clearable/>
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Cancelar" wire:click="cancel" />
                <x-button label="Salvar!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </div>
</div>