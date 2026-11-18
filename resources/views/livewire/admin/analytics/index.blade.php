<div
    class="space-y-5"
>
  <div class="space-y-4">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
            Estadisticas - {{ $year }}
        </h1>
        <select wire:model.live="numMeses" class="mt-2 border border-zinc-200 rounded-md p-2 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
            <option value="3">Ultimos 3 meses</option>
            <option value="6">Ultimos 6 meses</option>
            <option value="12">Ultimos 12 meses</option>
        </select>
    </div>
        <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-400">
            En esta sección puedes revisar las estadisticas de tus ventas 
        </p>
    </div>
     <div 
        x-data="{
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
        }"
        wire:ignore
        class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 shadow-sm"
    >
        <div x-ref="chart"></div>
    </div>

    @foreach ($topProductos as $item)
    <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-800 dark:bg-zinc-900 shadow-sm">
        <span>{{ $item->product?->name ?? 'Producto no disponible' }}</span>
        <span>{{ $item->total_vendidos }} unidades vendidas</span>
        <span>${{ number_format((float) $item->total_recaudado, 2) }}</span>
    </div>
    @endforeach
</div>

