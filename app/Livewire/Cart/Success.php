<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.marketplace-layout')]
class Success extends Component
{
    public function render()
    {
        $products = Product::whereIn('id', array_keys(session('cart', [])))->get();
        session()->forget('cart');

        return view('livewire.cart.success', [
            'products' => $products,
        ]);
    }
}
