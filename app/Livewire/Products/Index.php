<?php

namespace App\Livewire\Products;
use Livewire\Attributes\Layout;
use App\Models\Product;

use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.products.index',[
            'products' => Product::latest()->paginate(10),
        ]);
    }
}
