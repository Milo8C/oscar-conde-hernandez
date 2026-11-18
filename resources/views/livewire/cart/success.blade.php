<div @if($order->status === 'pendiente') wire:poll.3s @endif class="mx-auto max-w-4xl py-6 sm:py-10">
    <div
        class="overflow-hidden rounded-3xl border border-zinc-200/80 bg-white p-6 shadow-sm sm:p-8 dark:border-zinc-800 dark:bg-zinc-900">

        <div class="text-center">
            @if ($order->status === 'pagado')
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 shadow-sm dark:bg-emerald-950/50 dark:text-emerald-400">
                    <flux:icon name="check-badge" class="size-10" />
                </div>
                <span
                    class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Pago completado
                </span>
                <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl dark:text-white">
                    ¡Gracias por tu compra!
                </h1>
                <p class="mx-auto mt-2 max-w-md text-sm text-zinc-500 dark:text-zinc-400">
                    Tu pago ha sido procesado exitosamente. Hemos comenzado a preparar tu pedido y te enviaremos una
                    notificación cuando esté en camino.
                </p>

            @elseif ($order->status === 'pendiente')
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 shadow-sm dark:bg-amber-950/50 dark:text-amber-400">
                    <flux:icon name="clock" class="size-9 animate-pulse" />
                </div>
                <span
                    class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-950/40 dark:text-amber-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-ping"></span> Procesando pago
                </span>
                <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl dark:text-white">
                    Estamos confirmando tu pago
                </h1>
                <p class="mx-auto mt-2 max-w-md text-sm text-zinc-500 dark:text-zinc-400">
                    Estamos validando los datos con tu entidad financiera. Esta pantalla se actualizará automáticamente en
                    unos momentos.
                </p>

            @else
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100 text-red-600 shadow-sm dark:bg-red-950/50 dark:text-red-400">
                    <flux:icon name="exclamation-triangle" class="size-9" />
                </div>
                <span
                    class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-950/40 dark:text-red-300">
                    Estado: {{ ucfirst($order->status) }}
                </span>
                <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl dark:text-white">
                    Estado de la orden
                </h1>
                <p class="mx-auto mt-2 max-w-md text-sm text-zinc-500 dark:text-zinc-400">
                    La orden se encuentra en revisión. Si tienes dudas, ponte en contacto con nuestro equipo de soporte.
                </p>
            @endif
        </div>
        <div
            class="mt-8 grid grid-cols-2 gap-4 rounded-2xl bg-zinc-50 p-4 text-left sm:grid-cols-4 sm:p-5 dark:bg-zinc-800/60">
            <div>
                <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Código de Pedido</span>
                <span
                    class="mt-1 block font-mono text-sm font-bold text-zinc-900 dark:text-white">{{ $order->order_code }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Fecha</span>
                <span class="mt-1 block text-sm font-semibold text-zinc-900 dark:text-white">
                    {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : now()->format('d/m/Y') }}
                </span>
            </div>
            <div>
                <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Método de Pago</span>
                <div class="mt-1 flex items-center gap-1.5 text-sm font-semibold text-zinc-900 dark:text-white">
                    <flux:icon name="credit-card" class="size-4 text-blue-600 dark:text-blue-400" />
                    <span>Stripe</span>
                </div>
            </div>
            <div>
                <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Pagado</span>
                <span class="mt-1 block text-base font-extrabold text-blue-600 dark:text-blue-400">
                    ${{ number_format($order->total, 2) }} <span class="text-xs">MXN</span>
                </span>
            </div>
        </div>
        <div class="mt-8">
            <h2 class="text-sm font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                Productos Comprados ({{ $order->details->count() }})
            </h2>

            <div
                class="mt-3 divide-y divide-zinc-100 rounded-2xl border border-zinc-200/70 overflow-hidden dark:divide-zinc-800 dark:border-zinc-800">
                @foreach ($order->details as $item)
                    <div class="flex items-center justify-between p-4 bg-white dark:bg-zinc-900/50">
                        <div class="flex items-center gap-4 min-w-0">
                            <div
                                class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800">
                                @if ($item->product && $item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                        class="h-full w-full object-cover object-center" />
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-zinc-400">
                                        <flux:icon name="photo" class="size-6" />
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-medium text-sm text-zinc-900 truncate dark:text-white">
                                    {{ $item->product->name ?? 'Producto' }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Cant: <span class="font-semibold">{{ $item->quantity }}</span> &times;
                                    ${{ number_format($item->price_mxn, 2) }} MXN
                                </p>
                            </div>
                        </div>
                        <div class="text-right pl-4">
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                ${{ number_format($item->price_mxn * $item->quantity, 2) }} MXN
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6 border-t border-zinc-100 pt-5 dark:border-zinc-800">
            <div class="ml-auto max-w-xs space-y-2 text-sm">
                <div class="flex justify-between text-zinc-500 dark:text-zinc-400">
                    <span>Subtotal</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($order->subtotal, 2) }}
                        MXN</span>
                </div>
                <div class="flex justify-between text-zinc-500 dark:text-zinc-400">
                    <span>IVA (16%)</span>
                    <span class="font-medium text-zinc-800 dark:text-zinc-200">${{ number_format($order->iva, 2) }}
                        MXN</span>
                </div>
                <div class="flex justify-between text-zinc-500 dark:text-zinc-400">
                    <span>Envío</span>
                    <span class="font-medium text-emerald-600 dark:text-emerald-400">Gratis</span>
                </div>
                <div
                    class="flex justify-between border-t border-dashed border-zinc-200 pt-2 text-base font-bold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <span>Total</span>
                    <span class="text-blue-600 dark:text-blue-400">${{ number_format($order->total, 2) }} MXN</span>
                </div>
            </div>
        </div>
        <div
            class="mt-8 flex flex-col-reverse sm:flex-row items-center justify-between gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
            <a href="{{ route('welcome') }}" wire:navigate
                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-zinc-300 bg-white px-5 py-2.5 text-sm font-semibold text-zinc-700 shadow-2xs transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                <flux:icon name="arrow-left" class="size-4" />
                <span>Volver a la tienda</span>
            </a>

            <div class="flex w-full sm:w-auto items-center gap-2">
                <button type="button" onclick="window.print()"
                    class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    <flux:icon name="printer" class="size-4" />
                    <span>Imprimir comprobante</span>
                </button>
            </div>
        </div>

    </div>
</div>