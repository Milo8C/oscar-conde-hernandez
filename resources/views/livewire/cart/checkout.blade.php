<div x-data="{ flashMessage: '' }" class="grid grid-cols-1 gap-6 lg:grid-cols-4"    
    @cart-updated.window="flashMessage = 'Producto actualizado en el carrito'; setTimeout(() => flashMessage = '', 3500)"
    >

    <div class="col-span-3">
        <div class="space-y-3">
               <div class="flex items-center gap-2">
                <flux:icon name="arrow-left" class="size-5 text-zinc-500 dark:text-zinc-400" wire:navigate href="{{ route('welcome') }}" /> 
                <flux:button wire:navigate href="{{ route('welcome') }}" variant="subtle" class="px-0 py-0 text-sm font-semibold text-zinc-900 dark:text-white">
                    Continuar comprando
                </flux:button>
                </div>
            <div class="flex items-center gap-2">
             
            <flux:icon name="shopping-cart" class="size-6 text-primary-600" />
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Resumen del Carrito</h2>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Revisa los productos que has agregado a tu carrito antes
                de proceder al pago.</p>
        </div>
        <div class="mt-4 space-y-4">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div
                        class="flex items-center justify-between rounded-lg border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="flex items-center gap-4">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="h-16 w-16 rounded-lg object-cover object-center" />
                            <div>
                                <h3 class="font-medium text-zinc-900 dark:text-white">{{ $product->name }}</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Cantidad:
                                    {{ $cart[$product->id]['quantity'] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1">

                            <span
                                class="font-semibold text-zinc-900 dark:text-white">${{ number_format($product->price_mx * $cart[$product->id]['quantity'], 2) }}
                                MXN</span>
                            <span
                                class="text-sm text-zinc-500 dark:text-zinc-400">${{ number_format($product->price_usd * $cart[$product->id]['quantity'], 2) }}
                                USD</span>
                            <div class="flex items-center gap-2">
                                <div>
                                    <flux:button size="sm" wire:click="decreaseQuantity({{ $product->id }})">
                                        <flux:icon name="minus" class="size-4" />
                                    </flux:button>
                                    <span
                                        class="text-sm text-zinc-900 dark:text-white">{{ $cart[$product->id]['quantity'] }}</span>
                                    <flux:button size="sm" wire:click="increaseQuantity({{ $product->id }})">
                                        <flux:icon name="plus" class="size-4" />
                                    </flux:button>
                                </div>
                                <flux:button variant="danger" size="sm"
                                    wire:click="removeFromCart({{ $product->id }})">
                                    <flux:icon name="trash" class="size-4" />
                                </flux:button>
                            </div>
                        </div>


                    </div>
                @endforeach
            @else
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Tu carrito está vacío.</p>
            @endif

        </div>
    </div>

    <div>
        <p>Total</p>
        <p class="text-lg font-semibold text-zinc-900 dark:text-white">
            ${{ number_format($total, 2) }} MXN
        </p>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            ${{ number_format($totalUSD, 2) }} USD
        </p>
        <flux:separator class="my-4" />
        <p>Subtotal: ${{ number_format($subtotal, 2) }} MXN</p>
        <p>IVA: ${{ number_format($totalIva, 2) }} MXN</p>

        <div class="mt-6 flex justify-end">
            <flux:button variant="primary" wire:click="pay"
                class="px-6 py-3 text-base font-semibold shadow-sm w-full">
                Proceder al Pago
            </flux:button>
        </div>
    </div>
    <x-toast message-expression="flashMessage" />
</div>
