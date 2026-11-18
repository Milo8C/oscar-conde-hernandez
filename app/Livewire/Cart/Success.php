<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.marketplace-layout')]
class Success extends Component
{

    public Order $order;
    public function mount(Order $order)
    {
        $this->order = $order;
        session()->forget('cart');
    }
    public function render()
    {
        return view('livewire.cart.success', [
            'order' => $this->order->load('details.product'),
        ]);
    }
}
