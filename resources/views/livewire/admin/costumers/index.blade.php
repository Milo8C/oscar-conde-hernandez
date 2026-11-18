<div x-data="{ createOpen: false, flashMessage: '' }"
    @product-created.window="createOpen = false; flashMessage = $event.detail.message; setTimeout(() => flashMessage = '', 3500)"
    @product-deleted.window="flashMessage = 'Producto eliminado con éxito'; setTimeout(() => flashMessage = '', 3500)"
    class="space-y-6">
    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">
                    Clientes
                </flux:heading>
                <span
                    class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    {{ $customers->total() }} en total
                </span>
            </div>
            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Lista de clientes  
            </flux:text>
        </div>
    </div>
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex items-center justify-between border-b border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-950">
            <flux:input  wire:model.live.debounce.500ms="search" type="search" placeholder="Buscar cliente..." icon="magnifying-glass"
                class="max-w-md rounded-t-xl bg-zinc-50 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-primary-500 focus:ring-primary-500 dark:border-zinc-800 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500" />          
        </div>
        
        <flux:table :paginate="$customers" class="px-2">
            <flux:table.columns class="">
                <flux:table.column class="w-80 mx-2 "> Nombre</flux:table.column>
                <flux:table.column class="w-80 mx-2 "> Email</flux:table.column>
                <flux:table.column>Telefono</flux:table.column>
                <flux:table.column class="w-32">Curp</flux:table.column>
                <flux:table.column class="w-36">RFC</flux:table.column>
                <flux:table.column class="w-28">Fecha Registro</flux:table.column>   
                <flux:table.column class="w-28">Pedidos</flux:table.column>   
                <flux:table.column class="w-28">Total Gastado</flux:table.column>     
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($customers as $customer)
                    <flux:table.row :key="$customer->id"
                        class="transition-colors hover:bg-zinc-50/60 dark:hover:bg-zinc-800/40">
                        <!-- Producto (Miniatura + Nombre) -->
                        <flux:table.cell>
                            <div class="flex items-center gap-3 px-2">
                                {{ $customer->user->name }}
                            </div>
                        </flux:table.cell>
                        
                        <flux:table.cell>
                            <span class="line-clamp-2 text-xs text-zinc-600 dark:text-zinc-400">
                              {{ $customer->user->email }} 
                            </span>
                        </flux:table.cell>
                        
                        <flux:table.cell>
                           {{ $customer->phone ?? 'N/A' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div>
                               {{  $customer->curp ?? 'N/A' }} 
                            </div>
                        </flux:table.cell>
                        
                        <flux:table.cell>
                           {{  $customer->rfc ?? 'N/A' }} 
                        </flux:table.cell>
                        
                        <flux:table.cell class="">
                            <div class="flex items-center justify-end gap-1">
                               
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="">
                            <div class="flex items-center justify-end gap-1">
                               
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
                                <h3 class="mt-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100">No hay clientes
                                    registrados</h3>                             
                             
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    {{-- <x-toast message-expression="flashMessage" /> --}}
</div>