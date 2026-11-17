<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{

    //
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $description_short = '';

    #[Validate('nullable|string|max:1000')]
    public ?string $description_long = null;

    #[Validate('required|numeric|min:0')]
    public $price_mx = 0;

    #[Validate('required|numeric|min:0')]
    public float $price_usd = 0;

    #[Validate('nullable|image|max:2048')]
    public $image_url  = null;

    #[Validate('nullable|date')]
    public $validity_at = null;

    #[Validate('boolean')]
    public bool $active = false;

    #[Validate('nullable|integer|min:0')]
    public ?int $stock = null;

    #[Validate('required|exists:categories,id')]
    public ?int $category_id = null;
}
