<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $stats = [];
        if ($user->hasRole('Administrador')) {

            $pedidos = Order::count();
            $productos = Product::count();
            $clientes = Customer::count();
            $ventasHoy = Order::whereDate('created_at', Carbon::today())->sum('total');

            $stats = [
                ['label' => 'Ventas de hoy', 'value' => $ventasHoy, 'detail' => 'Sin ventas registradas'],
                ['label' => 'Pedidos', 'value' => $pedidos, 'detail' => 'Pendientes de atención'],
                ['label' => 'Productos', 'value' => $productos, 'detail' => 'En el catálogo'],
                ['label' => 'Clientes', 'value' => $clientes, 'detail' => 'Cuenta de administrador'],
            ];
        } else {
            $ventasHoy = $user->customer->orders()->whereDate('created_at', Carbon::today())->sum('total');
            $totalPedidos = $user->customer->orders()->count();
            $pedidosPendientes = $user->customer->orders()->where('status', 'pendiente')->count();
            $pedidosCompletados = $user->customer->orders()->where('status', 'pagado')->count();
            $pedidosCancelados = $user->customer->orders()->where('status', 'cancelado')->count();
            // $productos = $user->customer->products()->count();

            $stats = [
                ['label' => 'Compras de hoy', 'value' => $ventasHoy, 'detail' => 'Sin ventas registradas'],
                ['label' => 'Pedidos Pendientes', 'value' => $pedidosPendientes, 'detail' => 'Pendientes de atención'],
                ['label' => 'Pedidos Pagados', 'value' => $pedidosCompletados, 'detail' => 'En el catálogo'],
                ['label' => 'Pedidos Cancelados', 'value' => $pedidosCancelados, 'detail' => 'En el catálogo'],
                ['label' => 'Total de Pedidos', 'value' => $totalPedidos, 'detail' => 'En el catálogo'],
            ];
        }
        return view('livewire.dashboard', [
            'stats' => $stats
        ]);
    }
}
