<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Boncommerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @fluxAppearance    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body
    class="min-h-screen flex flex-col bg-zinc-50 font-sans text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
    <div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-600 px-4 py-2 text-center text-xs font-medium
        text-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <span class="hidden sm:inline">🚀 ¡Envíos gratis en pedidos seleccionados hoy!</span>
            <span class="mx-auto sm:mx-0">Atención al cliente 24/7 &bull; Compras 100% protegidas</span>
            <div class="hidden items-center gap-4 text-xs sm:flex">
                <a href="#" class="hover:underline opacity-90 hover:opacity-100 transition">Vender en el marketplace</a>
                <a href="#" class="hover:underline opacity-90 hover:opacity-100 transition">Ayuda</a>
            </div>
        </div>
    </div>
    <header 
        class="sticky top-0 z-40 border-b border-zinc-200/80 bg-white/95 backdrop-blurdark:border-zinc-800 dark:bg-zinc-900/95">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:gap-8 lg:px-8">
            <div class="flex items-center gap-3">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 group transition" wire:navigate>
                    @if(file_exists(public_path('images/large_boncommerce.webp')))
                        <img src="{{ asset('/images/large_boncommerce.webp') }}"
                            alt="{{ config('app.name', 'Marketplace') }}"
                            class="h-10 w-auto object-contain transition group-hover:scale-105">
                    @else
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 font-bold text-white shadow-md shadow-blue-500/20">
                            {{ substr(config('app.name', 'M'), 0, 1) }}
                        </div>
                        <span
                            class="text-xl font-bold tracking-tight text-zinc-900 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400 transition">
                            {{ config('app.name', 'Marketplace') }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Buscador Central -->
            <form action="{{ route('welcome') }}" method="GET" class="relative flex-1 max-w-2xl">
                <div class="relative flex items-center">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-zinc-400">
                        {{-- <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg> --}}
                    </div>
                    {{-- <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Buscar entre miles de productos, marcas y categorías..."
                        class="w-full rounded-full border border-zinc-300 bg-zinc-100/70 py-2.5 pl-11 pr-24 text-sm text-zinc-900 placeholder-zinc-500 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700 dark:bg-zinc-800/80 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-400 dark:focus:bg-zinc-900">
                    <button type="submit"
                        class="absolute right-1.5 inline-flex items-center rounded-full bg-blue-600 px-4 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900">
                        Buscar
                    </button> --}}
                </div>
            </form>
            <div x-data="{ cartCount: {{ collect(session('cart', []))->sum('quantity') }} }"
                x-on:cart-updated.window="cartCount = $event.detail.cartCount" class="flex items-center gap-2 sm:gap-4">
                <div x-data x-model="$flux.appearance">
                    <flux:dropdown position="bottom" align="start">
                        <flux:button icon="sun" variant="subtle" aria-label="Cambiar tema" />

                        <flux:menu>
                            <flux:menu.item x-on:click="$flux.appearance = 'light'">
                                Claro
                            </flux:menu.item>

                            <flux:menu.item x-on:click="$flux.appearance = 'dark'">
                                Oscuro
                            </flux:menu.item>

                            <flux:menu.item x-on:click="$flux.appearance = 'system'">
                                Usar sistema
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </div>
                @auth

                    <button type="button" aria-label="Carrito de compras" wire:navigate href="{{ route('cart.checkout') }}"
                        class="relative rounded-full p-2 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span
                            class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white">
                            <span x-text="cartCount"></span></span>
                    </button>
                    <div class="hidden h-5 w-px bg-zinc-200 dark:bg-zinc-700 sm:block"></div>
                    {{-- <div x-data x-model="$flux.appearance">
                        <flux:dropdown position="bottom" align="start">
                            <flux:button icon="sun" variant="subtle" aria-label="Cambiar tema" />

                            <flux:menu>
                                <flux:menu.item x-on:click="$flux.appearance = 'light'">
                                    Claro
                                </flux:menu.item>

                                <flux:menu.item x-on:click="$flux.appearance = 'dark'">
                                    Oscuro
                                </flux:menu.item>

                                <flux:menu.item x-on:click="$flux.appearance = 'system'">
                                    Usar sistema
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div> --}}

                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white py-1.5 pl-2 pr-3 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                        <span
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                        <span class="max-w-[100px] truncate sm:max-w-none">{{ auth()->user()->name }}</span>


                    </a>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white transition">
                            Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="hidden sm:inline-flex rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 transition">
                                Registrarse
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        <nav class="border-t border-zinc-100 bg-zinc-50/50 dark:border-zinc-800/80 dark:bg-zinc-900/50">
            <div
                class="mx-auto flex max-w-7xl items-center gap-6 overflow-x-auto px-4 py-2 text-xs font-medium text-zinc-600 no-scrollbar sm:px-6 lg:px-8 dark:text-zinc-400">
                <a href="{{ route('welcome') }}" wire:navigate
                    class="inline-flex items-center gap-1.5 font-semibold text-blue-600 dark:text-blue-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Todas las categorías
                </a>
                <span class="h-3 w-px bg-zinc-300 dark:bg-zinc-700"></span>

            </div>
        </nav>
    </header>
    <main class="flex-1 mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{ $slot }}
    </main>
    <footer
        class="mt-auto border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 text-sm">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-5">
                <div class="col-span-2">
                    <div class="flex items-center gap-2">
                        @if(file_exists(public_path('images/large_boncommerce.webp')))
                            <img src="{{ asset('/images/large_boncommerce.webp') }}" alt="Logo" class="h-9 w-auto">
                        @else
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 font-bold text-white">
                                {{ substr(config('app.name', 'M'), 0, 1) }}
                            </div>
                            <span
                                class="text-lg font-bold text-zinc-900 dark:text-white">{{ config('app.name', 'Marketplace') }}</span>
                        @endif
                    </div>
                    <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400 max-w-sm">
                        Tu destino preferido para descubrir, comprar y vender productos de calidad garantizada al
                        mejor
                        precio del mercado.
                    </p>
                    <div class="mt-4 flex gap-3 text-zinc-400">
                        <span class="text-xs">© {{ date('Y') }} {{ config('app.name', 'Boncommerce') }}. Todos los
                            derechos reservados.</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-900 dark:text-white">Comprar
                    </h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Explorar
                                catálogo</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Promociones</a>
                        </li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Tarjetas de
                                regalo</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Envíos y
                                cobertura</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-900 dark:text-white">Vender
                    </h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Vende tus
                                productos</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Planes para
                                vendedores</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Guía de
                                publicación</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Políticas de
                                ventas</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-zinc-900 dark:text-white">Soporte
                    </h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Centro de
                                ayuda</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Devoluciones</a>
                        </li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Términos y
                                condiciones</a></li>
                        <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Privacidad</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <x-toast />
    </footer>
    @fluxScripts
</body>

</html>