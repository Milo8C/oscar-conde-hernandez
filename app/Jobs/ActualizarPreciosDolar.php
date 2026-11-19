<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Product;

class ActualizarPreciosDolar implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $productIds, public float $tipoCambio)
    {
        //

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if ($this->tipoCambio <= 0 || empty($this->productIds)) {
            return;
        }

        $productos = Product::whereIn('id', $this->productIds)->get();

        foreach ($productos as $producto) {
            $producto->updateQuietly([
                'price_usd' => round($producto->price_mx / $this->tipoCambio, 2)
            ]);
        }
    }
}
