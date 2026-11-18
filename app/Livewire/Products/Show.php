<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.marketplace-layout')]
class Show extends Component
{
    public Product $product;

    public function render()
    {
        $this->authorize('view', $this->product);
        return view('livewire.products.show');
    }
}
