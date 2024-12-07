<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Orders | Spartan Commerce')]
class MyOrderPage extends Component
{
    use WithPagination;
    public function render()
    {
        $my_order = Order::where('user_id', auth()->id())->latest()->paginate(5);
        
        return view('livewire.my-order-page', [
            'my_order' => $my_order,
        ]);
    }
}
