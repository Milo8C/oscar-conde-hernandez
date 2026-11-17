<div x-data="{ createOpen: false, flashMessage: '' }"
    @product-created.window="createOpen = false; flashMessage = $event.detail.message; setTimeout(() => flashMessage = '', 3500)"
    @product-deleted.window="flashMessage = 'Producto eliminado con éxito'; setTimeout(() => flashMessage = '', 3500)"
    class="space-y-6">

    <!-- Header y Acciones Principales -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">
                    Productos
                </flux:heading>
                <span
                    class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    {{ $products->total() }} en total
                </span>
            </div>
            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Gestiona el inventario, precios y disponibilidad de tu catálogo.
            </flux:text>
        </div>

        <div class="flex items-center gap-3">
            <flux:button type="button" icon="trash" href="{{ route('admin.products.trash') }}">
                Papelera
            </flux:button>
            <flux:button type="button" variant="primary" icon="plus" @click="createOpen = true">
                Agregar producto
            </flux:button>
        </div>
    </div>

    <!-- Contenedor de la Tabla con bordes pulidos y sombras suaves -->
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-800 dark:bg-zinc-900">
        <flux:table :paginate="$products">
            <flux:table.columns>
                <flux:table.column class="w-80">Producto</flux:table.column>
                <flux:table.column>Descripción</flux:table.column>
                <flux:table.column class="w-32">Stock</flux:table.column>
                <flux:table.column class="w-36">Precio (MXN)</flux:table.column>
                <flux:table.column class="w-28">Estado</flux:table.column>
                <flux:table.column class="w-28 text-right">Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($products as $product)
                    <flux:table.row :key="$product->id"
                        class="transition-colors hover:bg-zinc-50/60 dark:hover:bg-zinc-800/40">
                        <!-- Producto (Miniatura + Nombre) -->
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                @if ($product->image_url)
                                    <img class="size-11 shrink-0 rounded-lg object-cover ring-1 ring-zinc-200/80 dark:ring-zinc-700/80"
                                        src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <div
                                        class="flex size-11 shrink-0 items-center justify-center rounded-lg border border-dashed border-zinc-300 bg-zinc-100 text-zinc-400 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-zinc-500">
                                        <flux:icon name="photo" class="size-5" />
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $product->name }}
                                    </p>
                                    @if ($product->slug)
                                        <p class="truncate text-xs text-zinc-400">
                                            /{{ $product->slug }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </flux:table.cell>

                        <!-- Descripción corta -->
                        <flux:table.cell>
                            <span class="line-clamp-2 text-xs text-zinc-600 dark:text-zinc-400"
                                title="{{ $product->description_short }}">
                                {{ $product->description_short ?: '—' }}
                            </span>
                        </flux:table.cell>

                        <!-- Stock con badges semánticos -->
                        <flux:table.cell>
                            @if ($product->stock === 0)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-950/60 dark:text-red-400">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>
                                    Agotado
                                </span>
                            @elseif ($product->stock < 5)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-md bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-400">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                                    {{ $product->stock }} (Bajo)
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $product->stock }} disp.
                                </span>
                            @endif
                        </flux:table.cell>

                        <!-- Precio MXN y referencia USD si existe -->
                        <flux:table.cell>
                            <div>
                                <span class="font-semibold text-zinc-900 dark:text-zinc-100">
                                    ${{ number_format($product->price_mx, 2) }}
                                </span>
                                @if ($product->price_usd > 0)
                                    <span class="block text-[11px] text-zinc-400">
                                        ≈ ${{ number_format($product->price_usd, 2) }} USD
                                    </span>
                                @endif
                            </div>
                        </flux:table.cell>

                        <!-- Estado Activo / Inactivo -->
                        <flux:table.cell>
                            @if ($product->is_active)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100/70 px-2 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Activo
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-zinc-100 px-2 py-0.5 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                    <span class="size-1.5 rounded-full bg-zinc-400"></span>
                                    Inactivo
                                </span>
                            @endif
                        </flux:table.cell>

                        <!-- Acciones -->
                        <flux:table.cell class="">
                            <div class="flex items-center justify-end gap-1">
                                <flux:button variant="ghost" size="sm"
                                    href="{{ route('admin.products.edit', $product->slug) }}" icon="pencil"
                                    class="text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" />

                                <x-alert-confirm title="Eliminar producto"
                                    message="¿Seguro que deseas eliminar «{{ $product->name }}»? Esta acción no se puede deshacer."
                                    action="delete" :arguments="[$product->id]" confirm-text="Sí, eliminar">
                                    <flux:icon name="trash" class="size-4 text-red-500 hover:text-red-600 transition" />
                                </x-alert-confirm>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="py-12 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center justify-center text-center">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="shopping-bag" class="size-6 text-zinc-400" />
                                </div>
                                <h3 class="mt-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100">No hay productos
                                    registrados</h3>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Comienza agregando tu primer
                                    producto al catálogo para que tus clientes puedan comprarlo.</p>
                                <div class="mt-4">
                                    <flux:button type="button" variant="primary" size="sm" icon="plus"
                                        @click="createOpen = true">
                                        Crear primer producto
                                    </flux:button>
                                </div>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    <!-- Modal para Crear Producto con Backdrop Mejorado -->
    <div x-show="createOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-950/70 p-4 backdrop-blur-xs"
        @keydown.escape.window="createOpen = false">

        <div x-show="createOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="my-auto max-h-[92vh] w-full max-w-5xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-zinc-950/5 dark:bg-zinc-900 dark:ring-white/10"
            @click.outside="createOpen = false">
            <livewire:admin.products.create />
        </div>
    </div>

    <x-toast message-expression="flashMessage" />
</div>