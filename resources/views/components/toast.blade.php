<div 
    x-data="{
        show: false,
        message: '',
        type: 'success',
        timeout: null,
        trigger(msg, tipo = 'success') {
            this.message = msg;
            this.type = tipo;
            this.show = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => this.show = false, 4000);
        }
    }"
    @toast.window="trigger($event.detail.message, $event.detail.type)"
    x-show="show" 
    x-transition 
    x-cloak
    class="fixed right-5 top-5 z-[100] flex max-w-sm items-start gap-3 rounded-xl border bg-white p-4 shadow-lg dark:bg-zinc-900"
    :class="{
        'border-green-200 dark:border-green-900': type === 'success',
        'border-red-200 dark:border-red-900': type === 'error',
        'border-blue-200 dark:border-blue-900': type === 'info'
    }"
    role="status"
>    
    <template x-if="type === 'success'">
        <flux:icon name="check-circle" class="mt-0.5 size-5 shrink-0 text-green-600" />
    </template>
    <template x-if="type === 'error'">
        <flux:icon name="x-circle" class="mt-0.5 size-5 shrink-0 text-red-600" />
    </template>
    <template x-if="type === 'info'">
        <flux:icon name="information-circle" class="mt-0.5 size-5 shrink-0 text-blue-600" />
    </template>

    <p class="flex-1 text-sm text-zinc-800 dark:text-zinc-100" x-text="message"></p>

    <button type="button" @click="show = false" class="text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">
        <flux:icon name="x-mark" class="size-4" />
    </button>
</div>