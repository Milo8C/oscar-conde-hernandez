<div class="space-y-6">    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <flux:heading size="xl" class="font-bold tracking-tight text-zinc-900 dark:text-white">
                    {{ auth()->user()->hasRole('admin') ? 'Productos' : 'Mis pedidos' }}
                </flux:heading>
                <span
                    class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    {{ $orders->total() }} en total
                </span>
            </div>
            <flux:text class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                {{ auth()->user()->hasRole('admin') ? 'Gestiona el inventario, precios y disponibilidad de tu catálogo.' : 'Aquí puedes ver tus pedidos.' }}
            </flux:text>
        </div>        
    </div>
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-xs dark:border-zinc-800 dark:bg-zinc-900 pb-4">
        <div class="flex items-center justify-between border-b border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-950">
            <flux:input  wire:model.live.debounce.500ms="search" type="search" placeholder="Buscar pedido..." icon="magnifying-glass"
                class="max-w-md rounded-t-xl bg-zinc-50 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-primary-500 focus:ring-primary-500 dark:border-zinc-800 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500" />

                <div class="flex items-center gap-2">
                    <flux:input wire:model.live.debounce.500ms="date_from" type="date"
                        class="max-w-md rounded-t-xl bg-zinc-50 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-primary-500 focus:ring-primary-500 dark:border-zinc-800 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500" />
                    <flux:input wire:model.live.debounce.500ms="date_to" type="date"
                        class="max-w-md rounded-t-xl bg-zinc-50 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-primary-500 focus:ring-primary-500 dark:border-zinc-800 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500" />
                </div>
        </div>        
        <flux:table :paginate="$orders" class="px-5">
            <flux:table.columns class="">
                <flux:table.column class="w-80 mx-2 "> Pedido</flux:table.column>
                @if(auth()->user()->hasRole('Administrador'))
                    <flux:table.column class="w-48">Cliente</flux:table.column>
                @endif
                <flux:table.column>Total</flux:table.column>
                <flux:table.column class="w-32">Fecha</flux:table.column>
                <flux:table.column class="w-36">Numero de productos</flux:table.column>
                <flux:table.column class="w-28">Estado</flux:table.column>      
                <flux:table.column class="w-28">Acciones</flux:table.column>            
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($orders as $order)
                    <flux:table.row :key="$order->id"
                        class="transition-colors hover:bg-zinc-50/60 dark:hover:bg-zinc-800/40">                        
                        <flux:table.cell>
                            {{ $order->order_code }}
                        </flux:table.cell> 
                        @if(auth()->user()->hasRole('Administrador'))    
                        <flux:table.cell>  
                            {{ $order->customer->user->name }}
                        </flux:table.cell>  
                        @endif   
                        <flux:table.cell>
                            {{ $order->total }}
                        </flux:table.cell>
                        
                        <flux:table.cell>
                           {{ $order->created_at }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div>
                                {{ count($order->details) }}  
                            </div>
                        </flux:table.cell>
                        
                        <flux:table.cell>
                           @if ($order->status == 'cancelado')
                               <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-950/60 dark:text-red-400">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>
                                    Cancelado
                                </span>
                            @elseif($order->status == 'pendiente')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-400">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span>
                                    Pendiente
                                </span>
                            @elseif($order->status == 'pagado')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Pagado
                                </span>
                               @elseif($order->status == 'fallido')
                               <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700 dark:bg-red-950/60 dark:text-red-400">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>
                                    Pago Fallido
                                </span> 
                            @endif  
                        </flux:table.cell>     
                        <flux:table.cell>
                            <flux:button href="{{ route('orders.show', $order->slug) }}" wire:navigate variant="outline" size="sm">
                                <flux:icon name="eye" class="size-4" />
                            </flux:button>                           
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
                                <h3 class="mt-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100">No hay pedidos
                                    registrados</h3>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>    
    
</div>