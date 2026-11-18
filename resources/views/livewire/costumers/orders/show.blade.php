<div class="space-y-6">    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <flux:button variant="ghost" size="sm" icon="arrow-left" href="{{ route('orders.index') }}" wire:navigate>
                    Volver
                </flux:button>
                <flux:heading size="xl" class="font-bold tracking-tight">
                    Pedido #{{ $order->order_code }}
                </flux:heading>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Realizado el {{ $order->created_at->translatedFormat('d \d\e F, Y \a \l\a\s H:i') }}
            </p>
        </div>

        <div>
            @php
                $statusColors = [
                    'pagado' => 'emerald',
                    'entregado' => 'emerald',
                    'procesando' => 'blue',
                    'enviado' => 'sky',
                    'pendiente' => 'amber',
                    'cancelado' => 'rose',
                    'fallido' => 'red',
                ];
                $color = $statusColors[$order->status] ?? 'zinc';
            @endphp
            <flux:badge :color="$color" size="lg" class="capitalize font-semibold tracking-wide">
                {{ $order->status }}
            </flux:badge>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">        
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-4 dark:border-zinc-800">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-white flex items-center gap-2">
                        <flux:icon name="shopping-bag" class="size-5 text-zinc-400" />
                        Artículos del pedido
                    </h2>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                        {{ $order->details->sum('quantity') }} {{ Str::plural('artículo', $order->details->sum('quantity')) }}
                    </span>
                </div>

                <div class="divide-y divide-zinc-100 dark:divide-zinc-800/80">
                    @foreach ($order->details as $detail)
                        <div class="flex items-center gap-4 py-4 first:pt-4 last:pb-0">                            
                            <div class="size-16 shrink-0 overflow-hidden rounded-xl border border-zinc-200/80 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-800/60">
                                @if ($detail->product?->image_url)
                                    <img src="{{ $detail->product->image_url }}" alt="{{ $detail->product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-zinc-400">
                                        <flux:icon name="photo" class="size-6" />
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                    {{ $detail->product?->name ?? 'Producto eliminado' }}
                                </h4>
                                @if($detail->product?->sku)
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500">
                                        SKU: {{ $detail->product->sku }}
                                    </p>
                                @endif
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Cantidad: <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $detail->quantity }}</span>
                                    <span class="mx-1.5 text-zinc-300 dark:text-zinc-600">•</span>
                                    ${{ number_format((float) $detail->price_mxn, 2) }} MXN c/u
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    ${{ number_format((float) ($detail->price_mxn * $detail->quantity), 2) }}
                                    <span class="text-xs font-normal text-zinc-500">MXN</span>
                                </p>
                                @if ($detail->price_usd)
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500">
                                        ${{ number_format((float) ($detail->price_usd * $detail->quantity), 2) }} USD
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="space-y-6">            
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-4">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-900 dark:text-white flex items-center gap-2">
                    <flux:icon name="receipt-percent" class="size-4 text-zinc-400" />
                    Resumen del Pago
                </h3>

                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>Subtotal</span>
                        <span>${{ number_format((float) $order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                        <span>IVA</span>
                        <span>${{ number_format((float) $order->iva, 2) }}</span>
                    </div>

                    <div class="border-t border-zinc-100 pt-3 dark:border-zinc-800">
                        <div class="flex items-baseline justify-between">
                            <span class="text-base font-bold text-zinc-900 dark:text-white">Total</span>
                            <div class="text-right">
                                <span class="text-xl font-extrabold text-zinc-900 dark:text-white">
                                    ${{ number_format((float) $order->total, 2) }}
                                </span>
                                <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400">MXN</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-3">
                <h3 class="text-sm font-semibold uppercase tracking-wider text-zinc-900 dark:text-white flex items-center gap-2">
                    <flux:icon name="user" class="size-4 text-zinc-400" />
                    Cliente
                </h3>

                <div class="text-sm space-y-1">
                    <p class="font-medium text-zinc-900 dark:text-zinc-100">
                        {{ $order->customer?->user?->name ?? 'N/A' }}
                    </p>
                    <p class="text-zinc-500 dark:text-zinc-400 text-xs">
                        {{ $order->customer?->user?->email ?? '' }}
                    </p>
                    @if ($order->customer?->phone)
                        <p class="text-zinc-500 dark:text-zinc-400 text-xs flex items-center gap-1.5 pt-1">
                            <flux:icon name="phone" class="size-3.5 text-zinc-400" />
                            {{ $order->customer->phone }}
                        </p>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>
