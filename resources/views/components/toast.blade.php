@props(['messageExpression' => '', 'type' => 'success',])

<div x-show="{{ $messageExpression }}" x-transition x-cloak
    class="fixed right-5 top-5 z-[100] flex max-w-sm items-start gap-3 rounded-xl border border-green-200 bg-white p-4 text-zinc-800 shadow-lg dark:border-green-900 dark:bg-zinc-900 dark:text-zinc-100"
    role="status">
    <flux:icon
        name="{{ $type === 'success' ? 'check-circle' : ($type === 'error' ? 'x-circle' : 'information-circle') }}"
        class="mt-0.5 size-5 shrink-0 text-{{ $type === 'success' ? 'green' : ($type === 'error' ? 'red' : 'blue') }}-600" />

    <p class="flex-1 text-sm" x-text="{{ $messageExpression }}"></p>

    <button type="button" @click="{{ $messageExpression }} = ''"
        class="text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200" aria-label="Cerrar">
        <flux:icon name="x-mark" class="size-4" />
    </button>
</div>