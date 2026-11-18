<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Demo') }}</title>

    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-100 antialiased dark:bg-zinc-950">
    <flux:sidebar sticky collapsible="mobile"
        class="border-r border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">

        <flux:sidebar.header class="text-center">
            <div class="flex justify-center items-center w-full">
                <img src="{{ asset('/images/large_boncommerce.webp') }}" alt="Logo" class="h-20">
            </div>
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group heading="Administración">
                <flux:sidebar.item icon="squares-2x2" href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? '!bg-neutral-500 !text-zinc-100' : '' }}"
                    :current="request()->routeIs('dashboard')">
                    Resumen
                </flux:sidebar.item>
            </flux:sidebar.group>
            @if(auth()->user()->hasRole('Administrador'))
                <flux:sidebar.group heading="Tienda">
                    <flux:sidebar.item icon="tag"
                        class="{{ request()->routeIs('admin.products.index') ? '!bg-neutral-500 !text-zinc-100' : '' }}"
                        href="{{ route('admin.products.index') }}">Productos</flux:sidebar.item>
                    <flux:sidebar.item icon="shopping-bag" href="#" wire:navigate>
                        Pedidos
                    </flux:sidebar.item>
                    <flux:sidebar.item
                        class="{{ request()->routeIs('admin.costumers.index') ? '!bg-neutral-500 !text-zinc-100' : '' }}"
                        icon="users" href="{{ route('admin.costumers.index') }}" wire:navigate>
                        Clientes
                    </flux:sidebar.item>
                </flux:sidebar.group>
            @else
                <flux:sidebar.group heading="Mi Cuenta">
                    <flux:sidebar.item icon="shopping-bag" href="#" wire:navigate>
                        Mis Pedidos
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" href="{{ route('welcome') }}" wire:navigate>
                        Productos
                    </flux:sidebar.item>
                </flux:sidebar.group>
            @endif

            <flux:sidebar.group heading="Sistema">
                <flux:sidebar.item icon="cog-6-tooth"
                    class="{{ request()->routeIs('profile') ? '!bg-neutral-500 !text-zinc-100' : '' }}"
                    href="{{ route('profile') }}" wire:navigate>
                    Configuración
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>


        <flux:sidebar.spacer />
        <flux:dropdown x-data position="bottom" align="start">
            <flux:button icon="sun" variant="subtle">
                Apariencia
            </flux:button>

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">
                    Claro
                </flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">
                    Oscuro
                </flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">
                    Usar sistema
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile name="{{ auth()->user()->name }}" />

            <flux:menu>
                <flux:menu.item href="{{ route('profile') }}" icon="user">
                    Mi perfil
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                        Cerrar sesión
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="block! border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <flux:navbar class="w-full lg:hidden">
            <flux:sidebar.toggle icon="bars-2" inset="left" />
            <flux:spacer />

            <flux:dropdown position="bottom" align="end">
                <flux:profile name="{{ auth()->user()->name }}" />

                <flux:menu>
                    <flux:menu.item href="{{ route('profile') }}" icon="user">
                        Mi perfil
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                            Cerrar sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:navbar>

        <flux:navbar scrollable>
            <flux:navbar.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">
                Panel
            </flux:navbar.item>
            <flux:navbar.item href="#">Pedidos</flux:navbar.item>
            <flux:navbar.item href="#">Catálogo</flux:navbar.item>
            <flux:navbar.item href="#">Configuración</flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

    </flux:header>

    <flux:main class="lg:ms-0 lg:mt-0">
        {{ $slot }}
    </flux:main>

    @fluxScripts
</body>

</html>