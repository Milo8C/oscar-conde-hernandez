<?php

namespace App\Livewire\Admin\Products;

use App\Livewire\Forms\ProductForm;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ConvertirPesosADolares;
use App\Livewire\Concerns\HasPriceConversion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Create extends Component
{
    public ProductForm $form;
    use WithFileUploads, HasPriceConversion;

    public ?string $conversionId = null;
    public bool $isConverting = false;
    public int $conversionStartedAt = 0;
    public ?string $conversionError = null;

    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        return view('livewire.admin.products.create', ['categories' => $categories]);
    }

    public function save()
    {
        $this->authorize('create', Product::class);
        $data = $this->form->validate();

        if ($this->form->image_url) {
            $data['image_url'] = '/storage/' . $this->form->image_url->store('products', 'public');
        }
        unset($data['image']);
        Product::create($data);
        session()->flash('success', 'Producto creado exitosamente');
        $this->form->reset();
        $this->dispatch('product-created', message: 'Producto creado exitosamente');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
