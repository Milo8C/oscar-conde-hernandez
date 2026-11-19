<div class="space-y-5">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
            Productos
        </h1>
        <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-400">
            En esta sección puedes revisar los productos que tienes disponibles en tu tienda y agregar los que desees a
            tu carrito.
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <aside class="col-span-1">
            <div
                class="sticky top-6 space-y-6 rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-zinc-500 dark:text-zinc-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        <h2 class="text-sm font-semibold tracking-wide uppercase text-zinc-900 dark:text-white">Filtros
                        </h2>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <flux:input type="text" wire:model.live.debounce.200ms="search" placeholder="Buscar productos..."
                        icon="magnifying-glass" clearable />
                </div>

                @if($search || $cats)
                    <div>
                        <flux:button wire:click="clearFilters" icon="x-mark"
                            class="cursor-pointer text-xs text-re !bg-red-500/10 dark:bg-red-500/20d-500">Limpiar Filtros
                        </flux:button>
                    </div>
                @endif
                <div class="space-y-3">
                    <label class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Categorías
                    </label>
                    <div class="space-y-2 overflow-y-auto pr-1">
                        @foreach ($categories as $category)
                            <div class="rounded-lg p-1.5 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                                <flux:checkbox wire:model.live="cats" value="{{ $category->id }}"
                                    label="{{ $category->name }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($products as $product)
                    <flux:card
                        class="group relative flex flex-col justify-between overflow-hidden rounded-2xl bg-white p-4 shadow-sm border border-zinc-200/80 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-zinc-300 dark:bg-zinc-900 dark:border-zinc-800 dark:hover:border-zinc-700">
                        <div class="space-y-4">
                            <div
                                class="relative aspect-square w-full overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover object-center transition-transform duration-500 ease-out group-hover:scale-105"
                                    loading="lazy" />
                            </div>

                            <div class="space-y-2">
                                <h3 class="font-medium text-zinc-900 line-clamp-1 group-hover:text-primary-600 transition-colors dark:text-zinc-100"
                                    title="{{ $product->name ?? 'Product Name' }}">
                                    {{ $product->name ?? 'Nombre del Producto' }}
                                </h3>

                                <div class="flex items-start justify-between gap-2">
                                    <span class="shrink-0 font-bold text-zinc-900 dark:text-white text-xl">
                                        {{ $product->price_mx ?? '0.00' }} MXN
                                    </span>
                                    <span
                                        class="shrink-0 text-sm font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                        <flux:icon name="currency-dollar" class="size-4" />
                                        {{ $product->price_usd ?? '0.00' }} USD
                                    </span>
                                </div>
                                <span
                                    class="shrink-0 text-sm font-semibold text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                    <flux:icon name="tag" class="size-4" /> {{ $product->category->name ?? 'Categoría' }}
                                </span>
                                <p class="text-xs text-zinc-500 line-clamp-2 dark:text-zinc-400 leading-relaxed">
                                    {{ $product->description_short }}
                                </p>

                            </div>
                        </div>
                        <div class="mt-4 grid pt-2 col-span-2 gap-3 w-full">
                            <flux:button class="w-full justify-center shadow-xs" wire:navigate
                                href="{{ route('products.show', $product->slug) }}">
                                <flux:icon name="eye" />
                                Ver producto
                            </flux:button>
                            @if(in_array($product->id, array_keys($cart)))
                                <a wire:key="product-cart-{{ $product->id }}"
                                    class="w-full justify-center shadow-xs flex py-2 rounded-xl !bg-green-800 !dark:bg-green-400 !text-neutral-100"
                                    wire:navigate href="{{ route('cart.checkout') }}">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="shopping-cart" /> <span> Ir al Carrito</span>
                                    </div>
                                </a>
                            @else
                                @if(auth()->check())
                                    @if($product->stock > 0)
                                        <flux:button variant="primary" class="w-full justify-center shadow-xs flex"
                                            wire:key="product-item-{{ $product->id }}" wire:click="addToCart({{ $product->id }})"
                                            wire:loading.attr="disabled">
                                            <div class="flex items-center gap-2">
                                                <flux:icon name="shopping-cart" /> <span> Agregar a Carrito</span>
                                            </div>
                                        </flux:button>
                                    @else
                                        <div class="flex items-center gap-2 bg-red-800 w-full text-white py-2 shadow-xs rounded-lg justify-center">
                                            <flux:icon name="shopping-cart" /> <span> Agotado</span>
                                        </div>
                                    @endif
                                @else
                                    <flux:button wire:key="product-login-{{ $product->id }}" variant="primary"
                                        class="w-full justify-center shadow-xs flex" wire:navigate href="{{ route('login') }}">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="shopping-cart" /> <span> Inicia sesión para agregar</span>
                                        </div>
                                    </flux:button>

                                @endif
                            @endif
                        </div>
                    </flux:card>
                @endforeach
            </div>
            <div class="mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>