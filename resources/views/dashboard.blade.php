<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <x-card title="À Receber" subtitle="Não atrasadas" shadow separator 0 relative
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            Não atrasadas
            </x-card>
            <x-card title="Vencidas" subtitle="Atrasadas" shadow separator
                class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            Vencidas
            </x-card>
        </div>
        <x-card title="Últimas vendas" shadow separator class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @php
                $vendas = \App\Models\Sale::orderBy('data', 'desc')->take(10)->get();
                $headers = [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'vencimento', 'label' => 'Vencimento'],
                    ['key' => 'valor_total', 'label' => 'Valor Total'],
                ];
            @endphp
            @foreach($vendas as $venda)
                {{-- <x-table :rows="$vendas" :headers="$headers" /> --}}
            @endforeach
        </x-card>
    </div>
</x-layouts.app>
