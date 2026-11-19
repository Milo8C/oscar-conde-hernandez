<?php

namespace App\Livewire\Products;

use App\Livewire\Concerns\HasAddCart;
use App\Models\Category;
use Livewire\Attributes\Layout;
use App\Models\Product;

use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.marketplace-layout')]
class Index extends Component
{

    use WithPagination, HasAddCart;

    public $search = '';
    public $cats = [];

    public function render()
    {
        $categories = Category::all();
        $cart = session()->get('cart', []);
        // dd([
        //     'cart' => $cart,
        //     'claves' => array_keys($cart),
        // ]);

        $products = Product::where('is_active', true)
            ->where(function ($query) {
                $query->whereDate('validity_at', '>=', now()->toDateString())
                    ->orWhereNull('validity_at');
            })
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('name', 'like', "%{$this->search}%");
                }
            })
            ->where(function ($query) {
                if ($this->cats) {
                    $query->whereIn('category_id', $this->cats);
                }
            })
            ->latest()->paginate(9);

        return view('livewire.products.index', [
            'products' => $products,
            'categories' => $categories,
            'cart' => $cart,
            'search' => $this->search,
            'cats' => $this->cats
        ]);
    }

    public function updatedSearch() {}



    public function clearFilters()
    {
        $this->search = '';
        $this->cats = [];
    }
}
