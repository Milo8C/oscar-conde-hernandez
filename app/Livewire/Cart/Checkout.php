<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.marketplace-layout')]
class Checkout extends Component
{
    public function render()
    {

        $cart = session()->get('cart', []);
        $products = \App\Models\Product::whereIn('id', array_keys($cart))->get();

        $total = array_reduce($products->toArray(), function ($carry, $product) use ($cart) {
            return $carry + ($product['price_mx'] * $cart[$product['id']]['quantity']);
        }, 0);

        $totalUSD = array_reduce($products->toArray(), function ($carry, $product) use ($cart) {
            return $carry + ($product['price_usd'] * $cart[$product['id']]['quantity']);
        }, 0);

        $iva = env('IVA', 0.16);
        $totalIva = $total * ($iva);

        $subtotal = $total - $totalIva;

        return view('livewire.cart.checkout', [
            'cart' => $cart,
            'products' => $products,
            'total' => $total,
            'subtotal' => $subtotal,
            'totalIva' => $totalIva,
            'totalUSD' => $totalUSD,
        ]);
    }

    public function removeFromCart(int $productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->dispatch('cart-updated');
    }

    public function decreaseQuantity(int $productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId]) && $cart[$productId]['quantity'] > 0) {
            $cart[$productId]['quantity']--;

            if ($cart[$productId]['quantity'] === 0) {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
            session()->flash('message', 'Producto actualizado en el carrito');
            $this->dispatch('cart-updated');
        }
    }

    public function increaseQuantity(int $productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->dispatch('cart-updated');
    }

    public function pay()
    {

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            session()->flash('error', 'El carrito está vacío.');
            return;
        }

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $lineItems = [];
        $products = Product::whereIn('id', array_keys($cart))->get();
        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'mxn',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price_mx * 100,
                ],
                'quantity' => $cart[$product->id]['quantity'],
            ];
        }


        $session = $stripe->checkout->sessions->create([            
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.checkout'),
        ]);

        return redirect($session->url);
    }
}
