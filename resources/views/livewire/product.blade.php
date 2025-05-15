<div>
    <h2>Tipos de Produtos</h2>
    <div wire:show="show_table">
        <div class="grid grid-cols-12">
            <div class="col-span-6">
                <x-input label="Busca" wire:model="busca" wire:change='getRecords' />
            </div>
            <div class="ml-14 mt-10 col-span-4">
                <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="create"
                    spinner>Nova
                    Categoria</x-button>
            </div>
        </div>
        <x-table :headers="$headers" :rows="$products" striped>
            @scope('cell_produto_tipo_id', $productType)
                {{ $productType->tipoProduto->nome }}
            @endscope
            @scope('cell_actions', $productType)
                <x-button icon="o-pencil" class="btn-sm" wire:click="edit('{{ $productType->id }}')" spinner />
                <x-button icon="o-trash" class="btn-sm" wire:click="delete({{ $productType->id }})" spinner wire:confirm="Deseja realmente excluir o registro selecionado?"/>
            @endscope
        </x-table>
    </div>

    <div wire:show="show_table==false">
        <x-form wire:submit="save">
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-2/3">
                    <x-input wire:model="productId" class="hidden" />
                    <x-input label="Produto" wire:model="nome" />
                    <x-input label="Código de Barras" wire:model="codigo_barras" />
                    <x-textarea label="Descrição" wire:model="descricao" />
                    <x-input label="Preço" wire:model="preco" />
                    <x-select label="Categoria" wire:model="produto_tipo_id" :options="$productTypes" option-label="nome" placeholder="Selecione a categoria..."/>
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Cancelar" wire:click="cancel"/>
                <x-button label="Salvar!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
