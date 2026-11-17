<?php

namespace App\Livewire\Forms\Admin\Products;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Edit extends Form
{
    public Product $product;

    #[Validate('required|string|min:3|max:255')]
    public string $name = '';

    #[Validate('required|string|min:3|max:255')]
    public string $slug = '';

    #[Validate('required|numeric|min:0')]
    public float $price_mx = 0;

    #[Validate('required|numeric|min:0')]
    public float $price_usd = 0;

    #[Validate('required|integer|min:0')]
    public int $stock = 0;

    #[Validate('required|string|min:3|max:255')]
    public string $description_short = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description_long = null;

    #[Validate('boolean')]
    public bool $is_active = false;

    #[Validate('nullable|image|max:2048')]
    public $image_url = null;

    #[Validate('nullable|date')]
    public $validity_at = null;

    #[Validate('required|exists:categories,id')]
    public ?int $category_id = null;

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->price_mx = (float) $product->price_mx;
        $this->price_usd = (float) $product->price_usd;
        $this->stock = (int) $product->stock;
        $this->description_short = $product->description_short ?? '';
        $this->description_long = $product->description_long;
        $this->is_active = (bool) $product->is_active;
        $this->category_id = $product->category_id;
        $this->validity_at = $product->validity_at ? date('Y-m-d\TH:i', strtotime($product->validity_at)) : null;
    }
}
