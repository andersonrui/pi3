<div>
    <h2>{{ $title }}</h2>
    <div wire:show="show_table">
        <div class="grid grid-cols-12">
            <div class="col-span-6">
                <x-input label="Busca" wire:model="busca" wire:change='getRecords' />
            </div>
            <div class="ml-14 mt-10 col-span-4">
                <x-button icon="o-plus" class="btn-sm btn-primary" wire:click="create" spinner>Novo Cliente</x-button>
            </div>
        </div>
        <x-table :headers="$headers" :rows="$customers" striped>
            @scope('cell_actions', $customer)
                <x-button icon="o-pencil" class="btn-sm" wire:click="edit('{{ $customer->id }}')" spinner />
                <x-button icon="o-trash" class="btn-sm" wire:click="delete({{ $customer->id }})" spinner
                    wire:confirm="Deseja realmente excluir o registro selecionado?" />
            @endscope
        </x-table>
    </div>

    <div wire:show="show_table==false">
        <x-form wire:submit="save">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-10">
                    <x-input wire:model="clienteId" class="hidden" />
                    <x-input label="Nome" wire:model="nome" />
                </div>
                <div class="col-span-2">
                    <x-input label="CPF" wire:model="cpf" />
                </div>
                <div class="col-span-1">
                    <x-input label="CEP" wire:model.blur="cep"/>
                </div>
                <div class="col-span-6">
                    <x-input label="Endereço" wire:model="endereco" />
                </div>
                <div class="col-span-2">
                    <x-input label="Bairro" wire:model="bairro" />
                </div>
                <div class="col-span-3">
                    <x-input label="Cidade" wire:model="cidade" />
                </div>
                <div class="col-span-2">
                    <x-input label="Telefone" wire:model="telefone" />
                </div>
                <div class="col-span-2">
                    <x-input label="Celular" wire:model="celular" />
                </div>
                <div class="md:w-1/3 mt-10 ml-4">
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
