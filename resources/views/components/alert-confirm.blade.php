@props([
    'title' => '¿Confirmar acción?',
    'message',
    'action',
    'arguments' => [],
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
])

<div x-data="{
        open: false,
        loading: false,
        action: @js($action),
        params: @js($arguments),

        async confirm() {
            this.loading = true;

            try {
                await $wire.call(this.action, ...this.params);
                this.open = false;
            } finally {
                this.loading = false;
            }
        }
    }">
    <button type="button" @click="open = true"
        class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950">
        {{ $slot->isEmpty() ? 'Eliminar' : $slot }}
    </button>

    <div x-show="open" x-cloak x-transition.opacity @keydown.escape.window="if (!loading) open = false"
        @click.self="if (!loading) open = false"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-900">
            <flux:heading size="lg">{{ $title }}</flux:heading>

            <flux:text class="mt-2  whitespace-pre-wrap">
                {{ $message }}
            </flux:text>

            <div class="mt-6 flex justify-end gap-3">
                <flux:button type="button" variant="ghost" @click="open = false" x-bind:disabled="loading">
                    {{ $cancelText }}
                </flux:button>

                <flux:button type="button" variant="primary" @click="confirm()" x-bind:disabled="loading">
                    <span x-show="!loading">{{ $confirmText }}</span>
                    <span x-show="loading">Procesando…</span>
                </flux:button>
            </div>
        </div>
    </div>
</div>