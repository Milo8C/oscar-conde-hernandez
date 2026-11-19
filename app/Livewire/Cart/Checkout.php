<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.marketplace-layout')]
class Checkout extends Component
{
    public function render()
    {

        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        $total = array_reduce($products->toArray(), function ($sum, $product) use ($cart) {
            return $sum + ($product['price_mx'] * $cart[$product['id']]['quantity']);
        }, 0);

        $totalUSD = array_reduce($products->toArray(), function ($sum, $product) use ($cart) {
            return $sum + ($product['price_usd'] * $cart[$product['id']]['quantity']);
        }, 0);

        $iva = config('services.iva');
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
        $this->dispatch('cart-updated', cartCount: collect($cart)->sum('quantity'));
        $this->dispatch('toast', message: 'Producto eliminado del carrito', type: 'success');
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
            $this->dispatch('cart-updated', cartCount: collect($cart)->sum('quantity'));
            $this->dispatch('toast', message: 'Producto actualizado en el carrito', type: 'success');
        }
    }

    public function increaseQuantity(int $productId)
    {
        $product = Product::find($productId);

        if ($product->stock == 0) {
            $this->dispatch('toast', type: 'error', message: 'Producto sin stock.');
            return;
        }

        $cart = session()->get('cart', []);

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

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
            $this->dispatch('cart-updated', cartCount: collect($cart)->sum('quantity'));
            $this->dispatch('toast', message: 'Producto actualizado en el carrito', type: 'success');
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->dispatch('cart-updated', cartCount: 0);
        $this->dispatch('toast', message: 'Carrito vaciado', type: 'success');
    }

    public function pay()
    {

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            $this->dispatch('cart-updated', cartCount: 0);
            $this->dispatch('toast', message: 'El carrito está vacío.', type: 'error');
            return;
        }

        $secret = config('services.stripe.secret');

        if (empty($secret)) {
            $this->dispatch('cart-updated');
            $this->dispatch('toast', message: 'Stripe secret no configurado.', type: 'error');

            return;
        }
        $stripe = new \Stripe\StripeClient($secret);


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

        $products = Product::whereIn('id', array_keys(session('cart', [])))->get();
        $cart = session('cart', []);

        $total = 0;
        foreach ($products as $product) {
            $total += $product->price_mx * $cart[$product->id]['quantity'];
        }
        $iva = $total * 0.16;
        $subtotal = $total - $iva;

        $existingOrder = Order::where('customer_id', auth()->user()->customer->id)
            ->where('status', 'pendiente')
            ->latest()
            ->first();

        if ($existingOrder) {
            $existingOrder->update(['status' => 'cancelado']);
        }

        $order = Order::create([
            'customer_id' => auth()->user()->customer->id,
            'order_code' => Order::generateOrderCode(),
            'subtotal' => $subtotal,
            'total' => $total,
            'iva' => $iva,
            'status' => 'pendiente',
            'paid_at' => null
        ]);

        foreach ($products as $product) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cart[$product->id]['quantity'],
                'price_mxn' => $product->price_mx,
                'price_usd' => $product->price_usd,
            ]);
        }


        $session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'customer_id' => auth()->user()->customer->id,
                'order_id' => $order->id,
            ],
            'success_url' => route('cart.success', $order),
            'cancel_url' => route('cart.checkout'),
        ]);

        return redirect($session->url);
    }
}
