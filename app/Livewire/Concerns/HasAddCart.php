<?php

namespace App\Livewire\Concerns;

use App\Jobs\ConvertirPesosADolares;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasAddCart
{

    public function addToCart(int $productId)
    {
        $product = Product::find($productId);

        if ($product->stock == 0) {
            $this->dispatch('toast', type: 'error', message: 'Producto sin stock.');
            return;
        }

        $cantidadEnCarrito = $cart[$productId]['quantity'] ?? 0;
        $nuevaCantidad = $cantidadEnCarrito + 1;

        if ($nuevaCantidad > $product->stock) {
            $this->dispatch(
                'toast',
                type: 'error',
                message: "Solo hay {$product->stock} unidades disponibles de este producto."
            );
            return;
        }
        $oldCart = session()->get('cart', []);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price_mx,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        session()->save();
        // dd([
        //     'productId recibido' => $productId,
        //     'claves despues' => array_keys($cart),
        //     'claves antes' => array_keys($oldCart),
        //     'cantidad antes' => $cart[$productId]['quantity'] ?? null,
        // ]);

        session()->flash('success', 'Producto agregado al carrito.');
        $this->dispatch(
            'cart-updated',
            cartCount: collect($cart)->sum('quantity')
        );
    }
}
