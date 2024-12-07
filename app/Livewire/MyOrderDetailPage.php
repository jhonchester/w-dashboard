<?php 
namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert; 

#[Title('My Order Detail | Spartan Commerce')]
class MyOrderDetailPage extends Component
{
    use LivewireAlert;
    public $order_id;
    public $rating = 0; // Store the selected rating
    public $productRatings = [];
    public $review = ''; // Store the review text
    public $order_items = []; // Declare the order_items property
    public $productReviews = []; // Declare the productReviews property

    // Method to update the rating and save to XML
    public function setRating($rating, $productName)
{
    //$this->rating = $rating;
    //$this->review = $this->productReviews[$productName] ?? '';

    $this->productRatings[$productName] = $rating;
    $this->review = $this->productReviews[$productName] ?? '';
    
    $user = auth()->user(); 

    $filePath = storage_path('app/ratings.xml');

    if (file_exists($filePath) && filesize($filePath) > 0) {
        $xml = simplexml_load_file($filePath);
    } else {
        $xml = new \SimpleXMLElement('<ratings></ratings>');
    }

    $existingRating = false;
    foreach ($xml->rating as $ratingItem) {
        // (string) $ratingItem->order_id === $orderId && 
        if ((string) $ratingItem->product === $productName) {
            $ratingItem->rating_value = $rating;
            $ratingItem->review = $this->review;
            $ratingItem->user_name = $user->name;
            $existingRating = true;
            break;
        }
    }

    if (!$existingRating) {
        $orderRating = $xml->addChild('rating');
       // $orderRating->addChild('order_id', $orderId);
        $orderRating->addChild('product', $productName);
        $orderRating->addChild('rating_value', $rating);
        $orderRating->addChild('review', $this->review);
        $orderRating->addChild('user_name', $user->name); 
        $orderRating->addChild('date', Carbon::now()->format('Y-m-d H:i:s'));
    }

    $xml->asXML($filePath);
}

public function mount($order_id)
{
    $this->order_id = $order_id;
    $filePath = storage_path('app/ratings.xml');

    $productRatings = [];
    $productReviews = []; // Initialize array for product reviews

    if (file_exists($filePath) && filesize($filePath) > 0) {
        // Load existing XML if the file exists
        $xml = simplexml_load_file($filePath);

        // Loop through all ratings in the XML and store them in arrays
        foreach ($xml->rating as $ratingItem) {
            // Check if the order ID matches and populate the product's ratings and reviews
            if ((string) $ratingItem->user_name === auth()->user()->name) {
                $productRatings[(string) $ratingItem->product] = (int) $ratingItem->rating_value;
                $productReviews[(string) $ratingItem->product] = (string) $ratingItem->review;
            }
        }
    }

    $this->productRatings = $productRatings;
    $this->productReviews = $productReviews; // Pass product reviews to the view

    // Retrieve order items for the order_id
    $this->order_items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
}

    public function submitReview()
{
    $filePath = storage_path('app/ratings.xml');
    $xml = simplexml_load_file($filePath);

    // Save the review for each item
    foreach ($this->order_items as $item) {
        // Use productReviews for each product to store the review and rating
        $this->setRating($this->productRatings[$item->product->name] ?? 0, $item->product->name);
    }
    $this->alert('success', 'Review submitted successfully!');
}
public function getCanSubmitReviewProperty()
{
    // Check if all items have both a rating and a review
    foreach ($this->order_items as $item) {
        // Check if either the rating or review is empty for any item
        if (empty($this->productRatings[$item->product->name]) || empty($this->productReviews[$item->product->name])) {
            return false;
        }
    }
    return true;
}
    public function render()
    {
        $order = Order::where('id', $this->order_id)->first();
        $user = auth()->user();

        // Format the claim date if it's not null
        $formatted_claim_date = optional($order->claim_date)
            ? (Carbon::parse($order->claim_date)->isToday()
                ? 'Pending date'
                : Carbon::parse($order->claim_date)->format('d-m-Y'))
            : 'No claim date';

        return view('livewire.my-order-detail-page', [
            'order' => $order,
            'order_items' => $this->order_items, // Use the class property
            'user' => $user,
            'formatted_claim_date' => $formatted_claim_date,
            'productRatings' => $this->productRatings,
            'productReviews' => $this->productReviews, // Pass product reviews to the view
        ]);
    }
}