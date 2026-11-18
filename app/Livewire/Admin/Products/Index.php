<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    #
    public $search = '';
    public $category_id = '';

    use WithPagination;
    public function render()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        // $products = Product::where('is_active', true)
        //     ->where(function ($query) {
        //         $query->whereDate('validity_at', '>', now()->toDateString())
        //             ->orWhereNull('validity_at');
        //     })
        //     ->latest()->paginate(9);

        $products = Product::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })->when($this->category_id, function ($query) {
            $query->where('category_id', $this->category_id);
        })->latest()->paginate(10);

        return view('livewire.admin.products.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function delete(int $product)
    {
        $product = Product::find($product);
        $this->authorize('delete', $product);

        $product->delete();
        $this->dispatch('product-deleted');
    }

    function toggleActive(int $product)
    {
        $product = Product::find($product);
        $this->authorize('update', $product);

        $product->is_active = !$product->is_active;
        $product->save();
        $this->dispatch('product-updated');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('product-created')]
    public function refreshProducts() {}
}
