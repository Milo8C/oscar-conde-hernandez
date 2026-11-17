<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.marketplace-layout')]
class Index extends Component
{
    #
    use WithPagination;
    public function render()
    {
        $categories = Category::latest()->get();
        $products = Product::where('is_active', true)
            ->where(function ($query) {
                $query->whereDate('validity_at', '>', now()->toDateString())
                    ->orWhereNull('validity_at');
            })
            ->latest()->paginate(9);
        return view('livewire.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function delete($product)
    {
        $product = Product::find($product);
        $product->delete();
        $this->dispatch('product-deleted');
    }

    #[On('product-created')]
    public function refreshProducts() {}
}
