<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Livewire\Partials\Navbar;

#[Title('Home Page | Spartan Commerce')]
class HomePage extends Component{
    use LivewireAlert;
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);

        // Dispatch event with the total cart count
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Product Added to the Cart Successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function render()
    {

        $categories = Category::where('is_active', 1)->get();
        $products = Product::where('is_featured', 1)
        ->where('in_stock', 1)
        ->where('is_active', 1)
        ->get();
        return view('livewire.home-page', [
            'categories' => $categories, 
            'products' => $products,  
        ]);
    }
}
