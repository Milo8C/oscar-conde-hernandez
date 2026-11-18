<div x-data="{ flashMessage: '', type: '' }" 
    @cart-updated.window="flashMessage = $event.detail.message; type = $event.detail.type; setTimeout(() => { flashMessage = ''; type = '' }, 3500)"
    class="py-4 sm:py-6"
>
    <!-- Encabezado / Botón Volver -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('welcome') }}" wire:navigate class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-500 transition-colors hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                <flux:icon name="arrow-left" class="size-4" />
                <span>Continuar comprando</span>
            </a>
            <div class="flex space-x-4 items-center">
            <h1 class="mt-2 text-2xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                Bolsa de Compras
            </h1>
            @if(count($products) > 0)
            <flux:button wire:click="clearCart" size="sm" color="neutral" variant="outline" icon="trash">
                Vaciar bolsa
            </flux:button>
            @endif
            </div>

        </div>
        @if (count($products) > 0)
            <div class="flex items-center gap-2 rounded-full bg-zinc-100 px-3.5 py-1.5 text-xs font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                <flux:icon name="shopping-bag" class="size-4 text-blue-600 dark:text-blue-400" />
                <span>{{ count($products) }} {{ count($products) === 1 ? 'artículo distinto' : 'artículos distintos' }}</span>
            </div>
        @endif
    </div>

    @if (count($products) > 0)
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-start">
            <!-- Lista de productos -->
            <div class="space-y-4 lg:col-span-8">
                <div class="divide-y divide-zinc-200/80 overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm dark:divide-zinc-800 dark:border-zinc-800 dark:bg-zinc-900">
                    @foreach ($products as $product)
                        <div class="flex flex-col gap-4 p-4 transition-colors hover:bg-zinc-50/50 sm:flex-row sm:items-center sm:justify-between sm:p-5 dark:hover:bg-zinc-800/40">
                            <!-- Info Producto e Imagen -->
                            <div class="flex items-start gap-4 sm:items-center">
                                <div class="relative h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 dark:border-zinc-800 dark:bg-zinc-800">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-zinc-900 line-clamp-1 dark:text-white">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                        Precio unitario: <span class="font-medium text-zinc-700 dark:text-zinc-300">${{ number_format($product->price_mx, 2) }} MXN</span>
                                    </p>
                                    <div class="mt-2 flex items-center gap-2 sm:hidden">
                                        <span class="text-sm font-bold text-zinc-900 dark:text-white">
                                            ${{ number_format($product->price_mx * $cart[$product->id]['quantity'], 2) }} MXN
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Controles de cantidad y precio -->
                            <div class="flex items-center justify-between border-t border-zinc-100 pt-3 sm:border-0 sm:pt-0 sm:justify-end sm:gap-6">
                                <!-- Selector de Cantidad -->
                                <div class="flex items-center rounded-xl border border-zinc-200 bg-zinc-50/80 p-0.5 dark:border-zinc-700 dark:bg-zinc-800">
                                    <button type="button" 
                                        wire:click="decreaseQuantity({{ $product->id }})" 
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-zinc-600 transition hover:bg-white hover:text-zinc-900 hover:shadow-xs active:scale-95 disabled:opacity-40 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-white"
                                        title="Disminuir">
                                        <flux:icon name="minus" class="size-3.5" />
                                    </button>
                                    <span class="w-9 text-center text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                        {{ $cart[$product->id]['quantity'] }}
                                    </span>
                                    <button type="button" 
                                        wire:click="increaseQuantity({{ $product->id }})" 
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-zinc-600 transition hover:bg-white hover:text-zinc-900 hover:shadow-xs active:scale-95 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-white"
                                        title="Aumentar">
                                        <flux:icon name="plus" class="size-3.5" />
                                    </button>
                                </div>

                                <!-- Precios Desktop -->
                                <div class="hidden text-right sm:block sm:min-w-[110px]">
                                    <div class="font-bold text-zinc-900 dark:text-white">
                                        ${{ number_format($product->price_mx * $cart[$product->id]['quantity'], 2) }} <span class="text-xs font-medium text-zinc-500">MXN</span>
                                    </div>
                                    <div class="text-xs text-zinc-400">
                                        ${{ number_format($product->price_usd * $cart[$product->id]['quantity'], 2) }} USD
                                    </div>
                                </div>

                                <!-- Eliminar -->
                                <button type="button" 
                                    wire:click="removeFromCart({{ $product->id }})" 
                                    class="rounded-lg p-2 text-zinc-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/30 dark:hover:text-red-400"
                                    title="Eliminar del carrito">
                                    <flux:icon name="trash" class="size-4" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Resumen de Compra -->
            <div class="lg:col-span-4">
                <div class="sticky top-24 rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">
                        Resumen del Pedido
                    </h2>

                    <div class="mt-5 space-y-3.5 text-sm">
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Subtotal</span>
                            <span class="font-medium text-zinc-900 dark:text-zinc-200">${{ number_format($subtotal, 2) }} MXN</span>
                        </div>
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>IVA estimado (16%)</span>
                            <span class="font-medium text-zinc-900 dark:text-zinc-200">${{ number_format($totalIva, 2) }} MXN</span>
                        </div>
                        <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                            <span>Envío</span>
                            <span class="font-medium text-emerald-600 dark:text-emerald-400">Gratis</span>
                        </div>

                        <div class="border-t border-dashed border-zinc-200 pt-3.5 dark:border-zinc-800">
                            <div class="flex items-baseline justify-between">
                                <span class="text-base font-bold text-zinc-900 dark:text-white">Total</span>
                                <div class="text-right">
                                    <div class="text-xl font-extrabold tracking-tight text-blue-600 dark:text-blue-400">
                                        ${{ number_format($total, 2) }} <span class="text-xs font-semibold">MXN</span>
                                    </div>
                                    <div class="text-xs font-medium text-zinc-400">
                                        aprox. ${{ number_format($totalUSD, 2) }} USD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <flux:button variant="primary" wire:click="pay" class="w-full justify-center py-3 text-base font-semibold shadow-md shadow-blue-500/10">
                            Proceder al Pago
                        </flux:button>
                    </div>

                    <!-- Sellos de confianza -->
                    <div class="mt-6 flex flex-col gap-2.5 border-t border-zinc-100 pt-4 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                        <div class="flex items-center gap-2">
                            <flux:icon name="shield-check" class="size-4 text-emerald-500" />
                            <span>Pago 100% seguro y encriptado</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon name="truck" class="size-4 text-blue-500" />
                            <span>Entrega rápida con seguimiento en vivo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Estado Carrito Vacío -->
        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-zinc-300 bg-white py-16 px-4 text-center dark:border-zinc-800 dark:bg-zinc-900/50">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500">
                <flux:icon name="shopping-bag" class="size-8" />
            </div>
            <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">Tu carrito está vacío</h3>
            <p class="mt-1 max-w-sm text-sm text-zinc-500 dark:text-zinc-400">
                Parece que aún no has agregado ningún producto. Explora nuestro catálogo y descubre grandes ofertas.
            </p>
            <div class="mt-6">
                <flux:button wire:navigate href="{{ route('welcome') }}" variant="primary" class="font-medium">
                    Explorar Productos
                </flux:button>
            </div>
        </div>
    @endif

    {{-- <x-toast message-expression="flashMessage" type="type" /> --}}
</div>
