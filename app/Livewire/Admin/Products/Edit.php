<?php

namespace App\Livewire\Admin\Products;

use App\Jobs\ConvertirPesosADolares;
use App\Livewire\Concerns\HasPriceConversion;
use App\Livewire\Forms\Admin\Products\Edit as FormEdit;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Edit extends Component
{
    use WithFileUploads, HasPriceConversion;

    public Product $product;
    public FormEdit $form;

    public ?string $conversionId = null;
    public bool $isConverting = false;
    public int $conversionStartedAt = 0;
    public ?string $conversionError = null;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->form->setProduct($product);
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();

        return view('livewire.admin.products.edit', [
            'categories' => $categories,
        ]);
    }

    public function save()
    {
        $this->authorize('update', $this->product);
        $data = $this->form->validate();

        if ($this->form->image_url) {
            $data['image_url'] = '/storage/' . $this->form->image_url->store('products', 'public');
        } else {
            unset($data['image_url']);
        }

        $this->product->update($data);

        $this->dispatch('product-edited');
        $this->dispatch('toast', message: 'Producto actualizado exitosamente');
    }

    #[On('product-edited')]
    public function refreshProduct(): void {}
}
