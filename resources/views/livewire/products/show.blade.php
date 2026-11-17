<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 space-y-6">
    <!-- Breadcrumb / Volver -->
    <nav class="flex items-center text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('welcome') }}" wire:navigate class="inline-flex items-center gap-1.5 transition-colors hover:text-zinc-800 dark:hover:text-zinc-200">
            <flux:icon name="arrow-left" class="size-4" />
            <span>Volver a productos</span>
        </a>
    </nav>

    <!-- Contenido principal -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Columna Izquierda: Galería/Imagen del Producto (7 cols en desktop) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="group relative overflow-hidden rounded-3xl border border-zinc-200/80 bg-zinc-100 dark:bg-zinc-800/70 dark:border-zinc-800 shadow-sm aspect-square md:aspect-[4/3] flex items-center justify-center">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                    class="h-full w-full object-cover object-center transition-transform duration-500 ease-out group-hover:scale-105"
                    loading="lazy" />

                <!-- Badge flotante de categoría -->
                @if($product->category)
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-zinc-800 backdrop-blur-md shadow-xs dark:bg-zinc-900/90 dark:text-zinc-200">
                            <flux:icon name="tag" class="size-3.5 text-zinc-500 dark:text-zinc-400" />
                            {{ $product->category->name }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Descripción larga / Ficha técnica -->
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-3">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white flex items-center gap-2">
                    <flux:icon name="document-text" class="size-5 text-zinc-400" />
                    Descripción del producto
                </h3>
                <div class="prose prose-zinc dark:prose-invert max-w-none text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed whitespace-pre-line">
                    {{ $product->description_long ?? ($product->description_short ?? 'Sin información detallada disponible para este producto.') }}
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Detalles de compra (5 cols en desktop) -->
        <div class="lg:col-span-5">
            <div class="sticky top-6 rounded-3xl border border-zinc-200/80 bg-white p-6 sm:p-8 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-6">
                <!-- Título y categoría -->
                <div class="space-y-2">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        {{ $product->name ?? 'Nombre del Producto' }}
                    </h1>
                    @if($product->description_short)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                            {{ $product->description_short }}
                        </p>
                    @endif
                </div>

                <!-- Precios -->
                <div class="rounded-2xl bg-zinc-50 p-4 border border-zinc-100 dark:bg-zinc-800/50 dark:border-zinc-800/80">
                    <div class="flex items-baseline gap-3 flex-wrap">
                        <span class="text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                            ${{ number_format((float) ($product->price_mx ?? 0), 2) }}
                            <span class="text-xs font-semibold uppercase text-zinc-500 dark:text-zinc-400">MXN</span>
                        </span>
                        @if($product->price_usd)
                            <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                / ${{ number_format((float) $product->price_usd, 2) }} USD
                            </span>
                        @endif
                    </div>
                    <span class="mt-1 block text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                        ✓ Impuestos incluidos
                    </span>
                </div>

                <!-- Bloque de Compra / Agregar al carrito -->
                <div class="space-y-4 pt-2">
                    <flux:button variant="primary" class="w-full justify-center py-3 text-base font-semibold shadow-sm">
                        <flux:icon name="shopping-cart" class="size-5 mr-2" />
                        Agregar al carrito
                    </flux:button>
                </div>

                <!-- Ventajas / Garantías -->
                <div class="border-t border-zinc-100 pt-5 dark:border-zinc-800/80 space-y-3">
                    <div class="flex items-center gap-3 text-xs text-zinc-600 dark:text-zinc-400">
                        <flux:icon name="truck" class="size-4 shrink-0 text-zinc-400" />
                        <span>Envíos seguros a todo el país</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-zinc-600 dark:text-zinc-400">
                        <flux:icon name="shield-check" class="size-4 shrink-0 text-zinc-400" />
                        <span>Compra 100% protegida y garantizada</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
