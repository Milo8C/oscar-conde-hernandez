<?php

namespace App\Livewire\Costumers\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public $search = '';
    public $date_from = '';
    public $date_to = '';

    public function render()
    {
        if (auth()->user()->hasRole('Cliente')) {
            $user = auth()->user();

            $orders = $user->customer->orders()->where('order_code', 'like', '%' . $this->search . '%')
                ->when($this->date_from && $this->date_to, function ($query) {
                    $query->whereBetween('created_at', [$this->date_from, $this->date_to]);
                })
                ->latest()
                ->paginate(10);
        } else {
            $orders = Order::where('order_code', 'like', '%' . $this->search . '%')
                ->when($this->search, function ($query) {
                    $query->orWhereHas('customer', function ($query) {
                        $query->whereHas('user', function ($query) {
                            $query->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%");
                        });
                    });
                })
                ->when($this->date_from && $this->date_to, function ($query) {
                    $query->whereBetween('created_at', [$this->date_from, $this->date_to]);
                })
                ->latest()->paginate(10);
        }

        return view('livewire.costumers.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function updatedSearch() {}

    public function updatedDateTo()
    {
        $this->validarFechas();
    }
    public function updatedDateFrom()
    {
        $this->validarFechas();
    }
    protected function validarFechas()
    {
        if ($this->date_to != '' && $this->date_from != '' && $this->date_to < $this->date_from) {
            $this->dispatch('toast', message: 'La fecha final debe ser mayor a la fecha inicial', type: 'error');
            $this->date_to = '';
            $this->date_from = '';
        }
    }
}
