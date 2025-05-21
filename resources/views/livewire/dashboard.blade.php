<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-2">
        <x-card title="À Receber" subtitle="Não atrasadas" shadow separator 0 relative
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-table :rows="$due_sales" :headers="$headers_due_sales">
                @scope('cell_cliente_id', $sale)
                    {{ $sale->cliente->nome }}
                @endscope
                @scope('cell_vencimento', $sale)
                    {{ Carbon\Carbon::createFromFormat('Y-m-d', $sale->vencimento)->format('d/m/Y') }}
                @endscope
            </x-table>
        </x-card>
        <x-card title="Vencidas" subtitle="Atrasadas" shadow separator
            class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-table :rows="$late_sales" :headers="$headers_late_sales">
                @scope('cell_cliente_id', $sale)
                    {{ $sale->cliente->nome }}
                @endscope
                @scope('cell_vencimento', $sale)
                    <div class="text-red-800">
                        {{ Carbon\Carbon::createFromFormat('Y-m-d', $sale->vencimento)->format('d/m/Y') }}</div>
                @endscope
            </x-table>
        </x-card>
    </div>
    <x-card title="Últimas vendas" shadow separator
        class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <x-table :rows="$last_sales" :headers="$headers_last_sales">
            @scope('cell_cliente_id', $sale)
                {{ $sale->cliente->nome }}
            @endscope
            @scope('cell_data', $sale)
                {{ Carbon\Carbon::createFromFormat('Y-m-d', $sale->data)->format('d/m/Y') }}
            @endscope
        </x-table>
    </x-card>
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');
    </script>
</div>
