<?php

namespace App\Livewire\Admin\Costumers;

use Livewire\Component;
use App\Models\Customer;
use GuzzleHttp\Psr7\Query;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $customers = Customer::when($this->search, function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%");
            });
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.costumers.index', compact('customers'));
    }

    public function updatedSearch() {}
}
