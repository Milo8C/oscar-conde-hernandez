<?php

namespace App\Livewire\Products;

use App\Livewire\Concerns\HasAddCart;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.marketplace-layout')]
class Show extends Component
{
    use HasAddCart;
    public Product $product;

    public function render()
    {
        $cart = session()->get('cart', []);
        $this->authorize('view', $this->product);
        return view('livewire.products.show', [
            'cart' => $cart
        ]);
    }
    public function updatedSearch() {}
}
