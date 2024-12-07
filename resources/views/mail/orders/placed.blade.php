<x-mail::message>
    # Order Placed Successfully

    Thankyou for purchasing! Your order number is: {{$order->id}}.

    <x-mail::button :url="$url">
        View Order
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
