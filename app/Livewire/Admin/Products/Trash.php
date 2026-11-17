<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Trash extends Component
{
    public function render()
    {
        $products = Product::onlyTrashed()->paginate(10);

        return view('livewire.admin.products.trash', [
            'products' => $products
        ]);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();

        session()->flash('success', 'Producto recuperado exitosamente');

        return redirect()->route('admin.products.index');
    }

    public function delete($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->forceDelete();

        session()->flash('success', 'Producto eliminado permanentemente exitosamente');

        return redirect()->route('admin.products.trash');
    }
}
