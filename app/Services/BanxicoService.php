<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BanxicoService
{
    public function datoOportuno(string $idSerie): array
    {
        return Cache::remember("banxico:serie:{$idSerie}", now()->addHours(12), function () use ($idSerie) {
            $response = Http::acceptJson()
                ->withHeaders([
                    'Bmx-Token' => config('services.banxico.key'),
                ])
                ->get("https://www.banxico.org.mx/SieAPIRest/service/v1/series/{$idSerie}/datos/oportuno");
            $response->throw();
            return $response->json('bmx.series.0') ?? [];
        });
    }

    public function convertirPesosADolares(float $pesos): array
    {
        $serie = $this->datoOportuno('SF43718');
        $tipoCambio = (float) ($serie['datos'][0]['dato'] ?? 0);
        if ($tipoCambio <= 0) {
            throw new \RuntimeException('Banxico no devolvió un tipo de cambio válido.');
        }

        return [
            'pesos' => $pesos,
            'tipo_cambio' => $tipoCambio,
            'usd' => round($pesos / $tipoCambio, 2),
        ];
    }
}
