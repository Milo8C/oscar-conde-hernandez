<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Services\BanxicoService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ActualizarProductosDolar extends Command
{
    /**
     * Nombre y firma del comando (permite el flag --force para forzar la actualización).
     */
    protected $signature = 'products:actualizar-dolar {--force : Forzar actualización aunque el dólar no haya cambiado}';

    /**
     * Descripción del comando.
     */
    protected $description = 'Actualizar precios en USD Productos';

    /**
     * Ejecutar el comando de consola.
     */
    public function handle(BanxicoService $banxicoService): int
    {
        $datos = $banxicoService->obtenerTipoCambioActual();
        $tipoCambioHoy = (float) ($datos['datos'][0]['dato'] ?? 0);

        if ($tipoCambioHoy <= 0) {
            return Command::FAILURE;
        }

        $tipoCambioGuardado = (float) Cache::get('banxico:ultimo_tipo_cambio', 0);

        if ($tipoCambioGuardado == $tipoCambioHoy && !$this->option('force')) {
            return Command::SUCCESS;
        }

        Product::query()
            ->where('price_mx', '>', 0)
            ->chunkById(200, function ($productos) use ($tipoCambioHoy) {
                foreach ($productos as $producto) {
                    $producto->updateQuietly([
                        'price_usd' => round($producto->price_mx / $tipoCambioHoy, 2)
                    ]);
                }
            });

        Cache::forever('banxico:ultimo_tipo_cambio', $tipoCambioHoy);
        Cache::put('banxico:serie:SF43718', $datos, now()->addDay()->setTime(12, 15, 0));
        return Command::SUCCESS;
    }
}
