<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;
use Stripe\Stripe;
use Stripe\Checkout\Session;

#[Title('Categories Page | Spartan Commerce')]
class CheckoutPage extends Component
{
    //address table edit this to user checkout details table
    public $first_name;
    public $last_name;
    public $suffix;
    public $sr_code;
    public $department;
    public $course;
    public $section;
    public $phone_number;
    public $email;
    public $payment_method;
    
    public function mount()
    {
        $this->email = auth()->user()->email ?? '';
    }
    public function placeOrder(){
        
        //dd($this->first_name, $this->last_name, $this->suffix, $this->sr_code, $this->department, $this->course, $this->section, 
        //$this->phone_number, $this->email, $this->payment_method);
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'suffix' => 'max:4',
            'sr_code' => 'required',
            'department' => 'required',
            'course' => 'required',
            'section' => 'required|numeric|digits:4',
            'phone_number' => 'required',
            'email' => 'required',
            'payment_method' => 'required',

        ]);
        
        $cart_items = CartManagement::getCartItemsFromCookie();

        $line_items=[];
        
        foreach($cart_items as $item){
            $line_items[] = [
                'price_data' => [
                    'currency' => 'php',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];
            
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'php';
        $order->note = 'Order placed by '. auth()->user()->name;

        $redirect_url = '';

        if($this->payment_method == 'ewallet'){
            
            
            Stripe::setApiKey('sk_test_51QMlThRsipeZzuAL1wWUQar1DqVEUzMusg8nPcfVNCkGZCPqr2HJS9CYYkDtlLcCnlNtW9vNAGZFoyaKchAiZJbP00lt9HoEvu');
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->user()->email,
                'line_items' => $line_items,
                'mode' => 'payment',
               
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}', 
                'cancel_url' => route('cancel'),
            ]);

            $redirect_url = $sessionCheckout->url;
        }else{
            $redirect_url = route('success');
        }

        $order->save();
        $order->items()->createMany($cart_items);
        CartManagement::clearCartItems($cart_items);
        Mail::to(request()->user())->send(new OrderPlaced($order));
        return redirect($redirect_url);
    }
    
    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.checkout-page',[
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}
