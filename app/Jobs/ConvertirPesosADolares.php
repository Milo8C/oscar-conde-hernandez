<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\BanxicoService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ConvertirPesosADolares implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public float $pesos,
        public string $conversionId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(BanxicoService $banxicoService): void
    {
        //            
        $key = "conversion:{$this->conversionId}";

        try {
            $precioFinal = $banxicoService->convertirPesosADolares(
                pesos: $this->pesos,
            );

            Cache::put($key, $precioFinal, now()->addHours(4));
        } catch (Throwable $e) {
            report($e);

            Cache::put(
                $key,
                ['error' => true],
                now()->addMinutes(5),
            );
        }
    }
}
