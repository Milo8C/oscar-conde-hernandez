<?php

namespace App\Livewire\Concerns;

use App\Jobs\ConvertirPesosADolares;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasPriceConversion
{
    public ?string $conversionId = null;
    public bool $isConverting = false;
    public int $conversionStartedAt = 0;
    public ?string $conversionError = null;

    public function convertirPrecio(): void
    {
        $this->validate([
            'form.price_mx' => 'required|numeric|min:0',
        ]);

        $this->conversionId = (string) Str::uuid();
        $this->conversionStartedAt = now()->timestamp;
        $this->conversionError = null;
        $this->isConverting = true;

        Cache::forget("conversion:{$this->conversionId}");

        ConvertirPesosADolares::dispatch(
            (float) $this->form->price_mx,
            $this->conversionId,
        );
    }

    public function revisarConversion(): void
    {
        if (! $this->conversionId) {
            return;
        }

        $key = "conversion:{$this->conversionId}";
        $precio = Cache::pull($key);

        if ($precio === null) {
            if (now()->timestamp - $this->conversionStartedAt >= 15) {
                $this->conversionError = 'La consulta tardó demasiado. Intenta de nuevo.';
                $this->conversionId = null;
                $this->isConverting = false;
            }

            return;
        }

        if (isset($precio['error'])) {
            $this->conversionError = 'No se pudo consultar el tipo de cambio. Intenta de nuevo.';
        } else {
            $this->form->price_usd = number_format(
                (float) $precio['usd'],
                2,
                '.',
                '',
            );
        }

        $this->conversionId = null;
        $this->isConverting = false;
    }
}
