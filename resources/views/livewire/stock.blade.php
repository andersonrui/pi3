<div>
    <h2>Controle de Estoque</h2>
    <div wire:show="show_table">
        <div class="grid grid-cols-12">
            <div class="col-span-6">
                <x-input label="Busca" wire:model="busca" wire:change='getRecords' />
            </div>
            <div class="ml-14 mt-10 col-span-4">
                <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="create" spinner>Alteração do estoque</x-button>
            </div>
        </div>
        <x-table :headers="$headers" :rows="$stocks" striped>
            @scope('cell_entrada', $stock)
                {{ Carbon\Carbon::createFromFormat('Y-m-d', $stock->entrada)->format('d/m/Y') }}
            @endscope
            @scope('cell_produto', $stock)
                {{ $stock->produto->nome }}
            @endscope
            @scope('cell_saldo', $stock)
                {{ $stock->saldo }}
            @endscope
            @scope('cell_actions', $stock)
                <x-button icon="o-trash" class="btn-sm" wire:click="delete({{ $stock->id }})" spinner
                    wire:confirm="Deseja realmente excluir o registro selecionado?" />
            @endscope
        </x-table>
    </div>

    <div wire:show="show_table==false">
        <x-form wire:submit="save">
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-2/3">
                    <x-input wire:model="stockId" class="hidden" />
                    <x-input wire:model="entrada" type="date" label="Data de Entrada"/>
                    <x-select label="Produto" wire:model="produtoId" :options="$products" option-label="nome" placeholder="Selecione o produto..."/>
                    <x-input wire:model="quantidade" label="Quantidade"/>
                </div>
                <div class="md:w-1/3 mt-8 ml-4">
                    <x-toggle label="Ativo" wire:model="ativo" />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Cancelar" wire:click="cancel" />
                <x-button label="Salvar!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
