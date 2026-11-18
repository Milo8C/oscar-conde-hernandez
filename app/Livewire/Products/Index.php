<?php

namespace App\Livewire\Products;

use App\Models\Category;
use Livewire\Attributes\Layout;
use App\Models\Product;

use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.marketplace-layout')]
class Index extends Component
{

    use WithPagination;

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
                $query->whereDate('validity_at', '>', now()->toDateString())
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

    public function addToCart(int $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
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

    public function clearFilters()
    {
        $this->search = '';
        $this->cats = [];
    }
}
