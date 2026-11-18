<?php

namespace App\Livewire\Costumers\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        $this->authorize('view', $this->order);
        return view('livewire.costumers.orders.show');
    }
}
