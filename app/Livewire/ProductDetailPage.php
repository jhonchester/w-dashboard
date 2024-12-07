<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Product Detail Page | Spartan Commerce')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $slug;
    public $quantity = 1;
    public $productRatings = [];

  
    public function rate($rating, $productName)
{
    // Update the rating for the specific product
    $this->productRatings[$productName] = $rating;
}
    public function increaseQty(){
        $this->quantity++;
    }
    public function decreaseQty(){
        if($this->quantity>1){
            $this->quantity--;
        }
    }

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);

        // Dispatch event with the total cart count
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Product Added to the Cart Successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    

    public function mount($slug){
        $this->slug= $slug;
    }
    public function render()
{
    $product = Product::where('slug', $this->slug)->firstOrFail();

    // Get the ratings from the XML file for this product
    $filePath = storage_path('app/ratings.xml');
    $averageRating = 0;
    $totalRatings = 0;
    $ratingSum = 0;
    $reviews = [];

    if (file_exists($filePath) && filesize($filePath) > 0) {
        $xml = simplexml_load_file($filePath);

        // Loop through all ratings and calculate the sum and total count for the product
        foreach ($xml->rating as $ratingItem) {
            if ((string) $ratingItem->product === $product->name) {
                $ratingSum += (int) $ratingItem->rating_value;
                $totalRatings++;
                $reviews[] = [
                    'user_name' => (string) $ratingItem->user_name,
                    'review' => (string) $ratingItem->review,
                    'rating' => (int) $ratingItem->rating_value,
                ];
            }
        }

        if ($totalRatings > 0) {
            $averageRating = $ratingSum / $totalRatings; // Calculate the average
        }
    }

    return view('livewire.product-detail-page', [
        'product' => $product,
        'averageRating' => $averageRating,
        'reviews' => $reviews, // Pass reviews to the view
    ]);
}


}
