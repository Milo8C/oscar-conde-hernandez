<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Panel de administración</p>
            <h1 class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">
                Hola, {{ auth()->user()->name }}
            </h1>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                    ['label' => 'Ventas de hoy', 'value' => '$0.00', 'detail' => 'Sin ventas registradas'],
                    ['label' => 'Pedidos', 'value' => '0', 'detail' => 'Pendientes de atención'],
                    ['label' => 'Productos', 'value' => '0', 'detail' => 'En el catálogo'],
                    ['label' => 'Clientes', 'value' => '1', 'detail' => 'Cuenta de administrador'],
                ] as $stat)
                <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                        {{ $stat['label'] }}
                    </p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                        {{ $stat['value'] }}
                    </p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $stat['detail'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <section
                class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 xl:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                            Actividad reciente
                        </h2>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            Aquí aparecerán los movimientos de tu tienda.
                        </p>
                    </div>
                    <span
                        class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        Próximamente
                    </span>
                </div>

                <div
                    class="mt-6 rounded-lg border border-dashed border-zinc-300 px-4 py-10 text-center dark:border-zinc-700">
                    <p class="font-medium text-zinc-700 dark:text-zinc-300">
                        Todavía no hay actividad
                    </p>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        Cuando registres pedidos o productos, verás aquí las novedades.
                    </p>
                </div>
            </section>

            <section
                class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                    Accesos rápidos
                </h2>

                <div class="mt-4 space-y-3">
                    <a href="#"
                        class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <span class="font-medium text-zinc-900 dark:text-white">Crear producto</span>
                        <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Agregar un artículo al
                            catálogo</span>
                    </a>

                    <a href="#"
                        class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <span class="font-medium text-zinc-900 dark:text-white">Ver pedidos</span>
                        <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Revisar compras
                            recientes</span>
                    </a>

                    <a href="{{ route('profile') }}"
                        class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <span class="font-medium text-zinc-900 dark:text-white">Mi perfil</span>
                        <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Actualizar tus datos</span>
                    </a>
                </div>
            </section>
        </div>

    </div>
</x-app-layout>