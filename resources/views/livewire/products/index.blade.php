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
        <div class="col-span-1 space-y-4 ">
            <h2>Filtros</h2>
            <flux:input type="text" placeholder="Buscar" />
            <div class="space-y-3">
                <label for="category" class="block mt-3">Categoría</label>
                @foreach ($categories as $category)
                    <flux:checkbox wire:model="category" value="{{ $category->id }}" label="{{ $category->name }}" />
                @endforeach
            </div>
        </div>
        <div class="col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($products as $product)
                    <flux:card
                        class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-4">
                        <image src="{{ $product->image_url }}" alt="{{ $product->name }}" />
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <flux:text variant="label">Product Name</flux:text>
                                <flux:text variant="subtitle">$199.00</flux:text>
                            </div>
                            <flux:text variant="muted">Short description of the product.</flux:text>
                        </div>
                        <flux:button variant="primary">Add to Cart</flux:button>
                    </flux:card>
                @endforeach
            </div>
            <div class="mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>