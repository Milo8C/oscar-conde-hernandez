<div class="space-y-5">
    <div class="space-y-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Estadisticas - {{ $year }}
            </h1>
            <select wire:model.live="numMeses"
                class="mt-2 border border-zinc-200 rounded-md p-2 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                <option value="3">Ultimos 3 meses</option>
                <option value="6">Ultimos 6 meses</option>
                <option value="12">Ultimos 12 meses</option>
            </select>
        </div>
        <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-400">
            En esta sección puedes revisar las estadisticas de tus ventas
        </p>
    </div>
    <div x-data="{
            chart: null,
            init() {
                let options = {
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false },
                        fontFamily: 'inherit',
                    },
                    series: [{
                        name: 'Ventas',
                        data: @js($ventas)
                    }],
                    xaxis: {
                        categories: @js($meses)
                    },
                    colors: ['#4f46e5'],
                    stroke: { curve: 'smooth', width: 2 },
                };
                this.chart = new ApexCharts(this.$refs.chart, options);
                this.chart.render();
                
                this.$watch('$wire.ventas', (nuevasVentas) => {
                    this.chart.updateOptions({
                        series: [{ data: nuevasVentas }],
                        xaxis: { categories: this.$wire.meses }
                    });
                });
            }
        }" wire:ignore
        class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 shadow-sm">
        <div x-ref="chart"></div>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Productos más vendidos</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Top productos con mayores ventas registradas</p>
            </div>
            <span class="rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                {{ count($topProductos) }} productos
            </span>
        </div>

        <div class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
            @forelse ($topProductos as $index => $item)
                <div class="flex items-center justify-between gap-4 py-3.5 transition-colors first:pt-0 last:pb-0 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 rounded-xl px-2">
                    <div class="flex items-center gap-3.5 min-w-0">
                        {{-- Badge de Ranking (#1, #2, #3 con distinción) --}}
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-xs font-bold
                            @if($index === 0) bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/50
                            @elseif($index === 1) bg-slate-200 text-slate-700 dark:bg-zinc-800 dark:text-zinc-300 border border-slate-300/60 dark:border-zinc-700
                            @elseif($index === 2) bg-orange-100 text-orange-700 dark:bg-orange-950/60 dark:text-orange-400 border border-orange-200/60 dark:border-orange-800/50
                            @else bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 @endif">
                            #{{ $index + 1 }}
                        </div>

                        {{-- Imagen del producto --}}
                        @if ($item->product?->image_url)
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product?->name }}"
                                class="h-11 w-11 shrink-0 rounded-lg object-cover border border-zinc-200 dark:border-zinc-700/60 bg-zinc-50 dark:bg-zinc-800">
                        @else
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-400 border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-800">
                                <flux:icon.photo class="size-5" />
                            </div>
                        @endif

                        {{-- Nombre y Unidades --}}
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-zinc-900 dark:text-white" title="{{ $item->product?->name }}">
                                {{ $item->product?->name ?? 'Producto no disponible' }}
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ number_format($item->total_vendidos) }}</span> unidades vendidas
                            </p>
                        </div>
                    </div>

                    {{-- Total Recaudado --}}
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                            ${{ number_format((float) $item->total_recaudado, 2) }}
                        </p>
                        <p class="text-[11px] text-zinc-400 dark:text-zinc-500">Recaudado</p>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    No hay ventas registradas aún.
                </div>
            @endforelse
        </div>
    </div>
</div>