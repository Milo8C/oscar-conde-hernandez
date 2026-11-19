<?php

namespace App\Livewire\Admin\Analytics;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;

#[Layout('layouts.app')]
class Index extends Component
{
    public $numMeses = 3;
    public array $meses = [];
    public array $ventas = [];

    public function render()
    {
        $this->meses = [];
        $this->ventas = [];
        $year = now()->year;

        // if ($this->numMeses == 6) {
        //     dd('6 meses');
        // }

        foreach (range((int)$this->numMeses - 1, 0) as $i) {
            $fecha = Carbon::now()->subMonths($i);
            $this->meses[] = ucfirst($fecha->translatedFormat('M'));
            $this->ventas[] = (float) Order::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->where('status', 'pagado')
                ->sum('total');
        }

        $topProductos = OrderDetail::query()
            ->whereHas('order', function ($query) {
                $query->where('status', 'pagado');
            })
            ->selectRaw('product_id, SUM(quantity) as total_vendidos, SUM(quantity * price_mxn) as total_recaudado')
            ->groupBy('product_id')
            ->orderByDesc('total_vendidos')
            ->with('product')
            ->take(3)
            ->get();

        return view('livewire.admin.analytics.index', [
            'year' => $year,
            'topProductos' => $topProductos,
        ]);
    }

    public function updatingNumMeses() {}
}
