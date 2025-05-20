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
                {{ $sale->pago ? 'Sim' : 'Não' }}
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
            <div class="md:grid md:items-center mb-6 grid-cols-12">
                <div class="col-span-1">
                    <x-input wire:model="data" type="date" label="Data da Venda" />
                </div>
                <div class="col-span-11 ml-3">
                    <x-input wire:model="saleId" class="hidden" />
                    <x-choices-offline 
                        label="Cliente" 
                        wire:model.live="clienteId" 
                        :options="$customers" 
                        option-label="nome"
                        placeholder="Selecione o cliente..." 
                        single 
                        searchable 
                        clearable 
                    />
                </div>
                <div class="col-spal-2">
                    <x-input wire:model="valorTotal" label="Valor Total" readonly />
                </div>
                <div class="col-span-1 ml-3">
                    <x-input wire:model="desconto" label="Desconto" />
                </div>
                <div class="col-span-1 ml-3 mt-8">
                    <x-toggle wire:model="pago" label="Pago" />
                </div>
                <div class="col-span-2 ml-3 mt-8" wire:show="is_adding_product==false">
                    <x-button label="Adicionar Produto" class="btn-warning" wire:click="adicionarProduto" />
                </div>
            </div>
            <div class="md:grid md:items-center mb-6 grid-cols-12" wire:show="is_adding_product">
                <h2>Adicionar Produto</h2>
                <div class="col-start-1 col-end-5">
                    <x-choices-offline label="Produto" wire:model="bag_produto_id"
                        :options="$products" option-label="nome" placeholder="Selecione um produto..." single searchable
                        clearable />
                </div>
                <div class="col-span-1 ml-3">
                    <x-input label="Quantidade" wire:model="bag_quantidade" wire:blur="getValorUnitario"/>
                </div>
                <div class="col-span-1 ml-3">
                    <x-input label="Valor Unitário" wire:model="bag_valor_unitario" readonly/>
                </div>
                <div class="col-span-1 ml-3">
                    <x-input label="Desconto" wire:model="bag_desconto" wire:blur="calculaValorProduto" />
                </div>
                {{-- <div class="col-span-1 ml-3">
                    <x-input label="Valor Total" wire:model="bag_total" readonly/>
                </div> --}}
                <div class="col-span-2 ml-3 mt-8">
                    <x-button label="Adicionar à venda" wire:click="add_to_bag" />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Cancelar" wire:click="cancel" />
                <x-button label="Salvar!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>

            <h1>Itens da Venda</h1>
            <x-table :headers="$products_sale_headers" :rows="$products_sale" striped>
                @scope('cell_desconto', $product)
                    {{ $product['desconto'] }}%
                @endscope
                @scope('cell_total', $product)
                    @php    
                        $this->calculaValorProduto()
                    @endphp
                @endscope
                @scope('cell_actions', $product)
                    <x-button icon="o-pencil" class="btn-sm" wire:click="editBag({{ $product['produto_id'] }})" spinner />
                    <x-button icon="o-trash" class="btn-sm" wire:click="deleteBag({{ $product['produto_id'] }})" spinner
                        wire:confirm="Deseja realmente excluir o registro selecionado?" />
                @endscope
            </x-table>
        </x-form>
    </div>
</div>
