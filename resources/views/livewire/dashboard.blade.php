<div>
    <div clas="my-5">
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Panel de administración</p>
        <h1 class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">
            Hola, {{ auth()->user()->name }}
        </h1>
    </div>
    @if(auth()->user()->hasRole('Administrador'))
        <div class="space-y-6 mt-4">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
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
                                Actividad Recientes
                            </h2>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                Aquí aparecerán los movimientos de tu tienda.
                            </p>
                        </div>
                    </div>
                    @if($actRecientes->count() > 0)
                        <div class="mt-6 flow-root">
                            <ul role="list" class="-mb-6">
                                @foreach ($actRecientes as $index => $act)
                                    <li>
                                        <div class="relative pb-6">
                                            @if(!$loop->last)
                                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-800"
                                                    aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex items-center space-x-3.5">
                                                <div>
                                                    <span
                                                        class="flex h-8 w-8 items-center justify-center rounded-full ring-4 ring-white dark:ring-zinc-900 {{ ($act['type'] ?? '') === 'order' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400' : 'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400' }}">
                                                        @if(($act['type'] ?? '') === 'order')
                                                            <flux:icon name="shopping-bag" class="size-4" />
                                                        @else
                                                            <flux:icon name="cube" class="size-4" />
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between items-center space-x-4">
                                                    <div>
                                                        <p
                                                            class="text-sm font-medium text-zinc-900 dark:text-white truncate max-w-xs sm:max-w-md">
                                                            {{ $act['name'] }}
                                                        </p>
                                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                            {{ $act['action'] }}
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="whitespace-nowrap text-right text-xs text-zinc-400 dark:text-zinc-500">
                                                        <time>{{ $act['time'] }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div
                            class="mt-6 flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-200 py-12 px-4 text-center dark:border-zinc-800">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500">
                                <flux:icon name="clock" class="size-6" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                Todavía no hay actividad hoy
                            </p>
                            <p class="mt-1 text-xs text-zinc-400 dark:text-zinc-500 max-w-xs">
                                Cuando se registren pedidos o productos durante el día, los verás listados aquí en
                                tiempo real.
                            </p>
                        </div>
                    @endif
                </section>

                <section
                    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-white">
                        Accesos rápidos
                    </h2>

                    <div class="mt-4 space-y-3">
                        <a href="{{ route('admin.products.index') }}" wire:navigate
                            class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                            <span class="font-medium text-zinc-900 dark:text-white">Productos</span>
                            <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Ver productos</span>
                        </a>

                        <a href="{{  route('orders.index') }}" wire:navigate
                            class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                            <span class="font-medium text-zinc-900 dark:text-white">Ver pedidos</span>
                            <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Revisar compras
                                recientes</span>
                        </a>

                        <a href="{{ route('profile') }}" wire:navigate
                            class="block rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                            <span class="font-medium text-zinc-900 dark:text-white">Mi perfil</span>
                            <span class="mt-1 block text-sm text-zinc-500 dark:text-zinc-400">Actualizar tus datos</span>
                        </a>
                    </div>
                </section>
            </div>

        </div>
    @else
        <div class="space-y-6 mt-4">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
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
        </div>

    @endif
</div>