<div class="mx-auto max-w-7xl space-y-6 pb-12"
    @product-edited.window="flashMessage = $event.detail.message; setTimeout(() => flashMessage = '', 3500)"
    @product-deleted.window="flashMessage = 'Producto eliminado con éxito'; setTimeout(() => flashMessage = '', 3500)"
    class="space-y-6">

    <!-- Encabezado de página completa -->
    <div
        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <div class="flex items-center gap-4">
            <flux:button icon="arrow-left" href="{{ route('admin.products.index') }}" variant="ghost" size="sm">
                Volver
            </flux:button>
            <div>
                <div class="flex items-center gap-3">
                    <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                        {{ $product->name }}
                    </flux:heading>
                    @if ($product->is_active)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100/80 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            Activo
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-semibold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            <span class="size-1.5 rounded-full bg-zinc-400"></span>
                            Inactivo
                        </span>
                    @endif
                </div>
                <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Modifica los datos del producto, actualiza precios con Banxico o administra su stock.
                </flux:text>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <flux:button variant="ghost" href="{{ route('admin.products.index') }}">
                Cancelar
            </flux:button>
            <flux:button type="submit" form="product-edit-form" variant="primary" icon="check"
                wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">
                    Guardar cambios
                </span>
                <span wire:loading wire:target="save">
                    Guardando...
                </span>
            </flux:button>
        </div>
    </div>

    <!-- Formulario Principal -->
    <form id="product-edit-form" wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- Columna Izquierda: Información de Contenido y Precios (8 cols) -->
            <div class="space-y-6 lg:col-span-8">

                <!-- Tarjeta: Información General -->
                <div
                    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-800 dark:bg-zinc-900/60">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <flux:icon name="information-circle" class="size-4 text-blue-500" />
                        Información general
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <flux:input label="Nombre del producto"
                                placeholder="Ej. Camiseta básica de algodón oversized" wire:model="form.name" />
                            @error('form.name')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>

                        <div>
                            <flux:input label="Slug / URL amigable" readonly placeholder="nombre-del-producto"
                                wire:model="form.slug" />
                            @error('form.slug')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>

                        <div>
                            <flux:textarea label="Descripción corta"
                                placeholder="Resumen atractivo para listados y tarjetas de producto..." rows="2"
                                maxlength="255" wire:model="form.description_short" />
                            <div class="mt-1 flex items-center justify-between text-xs text-zinc-400">
                                <span>Máx. 255 caracteres</span>
                            </div>
                            @error('form.description_short')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>

                        <div>
                            <flux:textarea label="Descripción detallada (opcional)"
                                placeholder="Especificaciones técnicas, materiales, guía de tallas, garantía..."
                                rows="5" maxlength="1000" wire:model="form.description_long" />
                            <div class="mt-1 flex items-center justify-between text-xs text-zinc-400">
                                <span>Máx. 1000 caracteres</span>
                            </div>
                            @error('form.description_long')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Precios y Conversión en Vivo -->
                <div
                    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-800 dark:bg-zinc-900/60">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            <flux:icon name="banknotes" class="size-4 text-emerald-500" />
                            Precios y Divisas
                        </h3>
                        <span
                            class="rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                            Tipo de cambio Banxico
                        </span>
                    </div>

                    <div class="grid grid-cols-1 items-start gap-4 sm:grid-cols-2">
                        <!-- Precio MXN -->
                        <div>
                            <flux:input type="number" min="0" step="0.01" label="Precio (MXN)" placeholder="0.00"
                                wire:model.live="form.price_mx" />
                            @error('form.price_mx')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror

                            <div class="mt-2.5">
                                <flux:button type="button" variant="subtle" size="sm" icon="arrow-path"
                                    class="w-full justify-center" wire:click="convertirPrecio"
                                    wire:loading.attr="disabled" wire:target="convertirPrecio"
                                    :disabled="$isConverting || (float) $form->price_mx <= 0">
                                    Convertir a USD
                                </flux:button>
                            </div>

                            @if ($conversionError)
                                <div role="alert"
                                    class="mt-2.5 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 p-2.5 text-xs text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                                    <flux:icon name="exclamation-circle" class="size-4 shrink-0 text-red-500" />
                                    <span>{{ $conversionError }}</span>
                                </div>
                            @endif

                            @if ($isConverting)
                                <div wire:poll.2s="revisarConversion"
                                    class="mt-2.5 flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 p-2 text-xs font-medium text-blue-600 dark:border-blue-900/50 dark:bg-blue-950/40 dark:text-blue-400">
                                    <flux:icon name="arrow-path"
                                        class="size-3.5 animate-spin text-blue-600 dark:text-blue-400" />
                                    <span>Consultando tipo de cambio con Banxico...</span>
                                </div>
                            @endif
                        </div>

                        <!-- Precio USD -->
                        <div>
                            <flux:input type="number" readonly min="0" step="0.01" label="Precio estimado (USD)"
                                placeholder="0.00" wire:model="form.price_usd"
                                class="cursor-not-allowed bg-zinc-50 text-zinc-600 dark:bg-zinc-800/50 dark:text-zinc-300" />
                            @error('form.price_usd')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                            <flux:text class="mt-1.5 text-xs text-zinc-400">
                                Calculado automáticamente vía Banxico.
                            </flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Estado, Categoría, Inventario y Multimedia (4 cols) -->
            <div class="space-y-6 lg:col-span-4">

                <!-- Tarjeta: Estado y Organización -->
                <div
                    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-800 dark:bg-zinc-900/60">
                    <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <flux:icon name="adjustments-horizontal" class="size-4 text-purple-500" />
                        Estado y Organización
                    </h3>

                    <div class="space-y-4">
                        <!-- Toggle de Estado Activo -->
                        <div
                            class="flex items-center justify-between rounded-lg border border-zinc-200 bg-zinc-50/60 p-3 dark:border-zinc-800 dark:bg-zinc-800/40">
                            <div>
                                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">Producto activo</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Visible para los clientes</p>
                            </div>
                            <flux:checkbox wire:model="form.is_active" />
                        </div>

                        <!-- Categoría -->
                        <div>
                            <flux:select label="Categoría" wire:model="form.category_id">
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </flux:select>
                            @error('form.category_id')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>

                        <!-- Stock Disponible -->
                        <div>
                            <flux:input type="number" min="0" label="Stock en almacén" placeholder="0"
                                wire:model="form.stock" />
                            @error('form.stock')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>

                        <!-- Vigencia -->
                        <div>
                            <flux:input type="datetime-local" label="Vigente hasta (opcional)"
                                wire:model="form.validity_at" />
                            @error('form.validity_at')
                                <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tarjeta: Imagen del Producto -->
                <div
                    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-xs dark:border-zinc-800 dark:bg-zinc-900/60">
                    <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <flux:icon name="photo" class="size-4 text-amber-500" />
                        Imagen del producto
                    </h3>

                    <!-- Imagen actual o nueva preview -->
                    @if ($form->image_url)
                        {{-- Imagen recién seleccionada pendiente de subir/guardar --}}
                        <div
                            class="relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 p-2.5 dark:border-zinc-700 dark:bg-zinc-800/50">
                            <span
                                class="mb-2 inline-block rounded-md bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                Nueva imagen seleccionada
                            </span>
                            <div
                                class="relative aspect-video w-full overflow-hidden rounded-lg bg-zinc-100 dark:bg-zinc-900">
                                <img src="{{ $form->image_url->temporaryUrl() }}" alt="Vista previa"
                                    class="h-full w-full object-cover">
                            </div>

                            <div class="mt-3 flex items-center justify-between gap-2 px-1">
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-semibold text-zinc-800 dark:text-zinc-200">
                                        {{ $form->image_url->getClientOriginalName() }}
                                    </p>
                                    <p class="text-[11px] text-zinc-400">
                                        {{ number_format($form->image_url->getSize() / 1024, 0) }} KB
                                    </p>
                                </div>

                                <flux:button type="button" variant="ghost" size="xs"
                                    wire:click="$set('form.image_url', null)"
                                    class="text-red-600 hover:text-red-700 dark:text-red-400">
                                    Deshacer
                                </flux:button>
                            </div>
                        </div>
                    @elseif ($product->image_url)
                        {{-- Imagen existente guardada en almacenamiento --}}
                        <div
                            class="relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 p-2.5 dark:border-zinc-700 dark:bg-zinc-800/50">
                            <div
                                class="relative aspect-video w-full overflow-hidden rounded-lg bg-zinc-100 dark:bg-zinc-900">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover">
                            </div>

                            <div class="mt-3 flex items-center justify-between gap-2 px-1">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">Imagen actual</span>
                                <label for="image_url"
                                    class="cursor-pointer text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                    Reemplazar imagen
                                </label>
                            </div>
                        </div>
                    @else
                        {{-- Sin imagen --}}
                        <label for="image_url"
                            class="group relative flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-300 bg-zinc-50/80 px-4 py-7 text-center transition hover:border-blue-500 hover:bg-blue-50/40 dark:border-zinc-700 dark:bg-zinc-800/40 dark:hover:border-blue-400 dark:hover:bg-zinc-800/70">

                            <div
                                class="rounded-full bg-white p-2.5 shadow-xs transition group-hover:scale-110 group-hover:bg-blue-50 dark:bg-zinc-800 dark:group-hover:bg-zinc-700">
                                <flux:icon name="arrow-up-tray"
                                    class="size-6 text-zinc-500 group-hover:text-blue-600 dark:text-zinc-400 dark:group-hover:text-blue-400" />
                            </div>

                            <span
                                class="mt-3 text-sm font-medium text-zinc-700 group-hover:text-blue-600 dark:text-zinc-300 dark:group-hover:text-blue-400">
                                Subir imagen
                            </span>
                            <span class="mt-1 text-xs text-zinc-400">
                                PNG, JPG o WEBP (máx. 2 MB)
                            </span>
                        </label>
                    @endif

                    <input id="image_url" type="file" accept="image/png,image/jpeg,image/webp"
                        wire:model="form.image_url" class="sr-only">

                    <!-- Loading feedback -->
                    <div wire:loading wire:target="form.image_url"
                        class="mt-2 flex items-center gap-2 text-xs font-medium text-blue-600 dark:text-blue-400">
                        <flux:icon name="arrow-path" class="size-4 animate-spin" />
                        <span>Cargando imagen...</span>
                    </div>

                    @error('form.image_url')
                        <flux:text class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Botones de acción en la parte inferior de la página -->
        <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-800">
            <flux:button variant="ghost" href="{{ route('admin.products.index') }}">
                Cancelar
            </flux:button>
            <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">
                    Guardar cambios
                </span>
                <span wire:loading wire:target="save">
                    Guardando...
                </span>
            </flux:button>
        </div>
    </form>
    <x-toast message-expression="flashMessage" />
</div>