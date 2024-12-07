{{-- resources/views/mail/subscribe.blade.php --}}

<x-mail::message>
    # Subscription Successful

    Hello, {{$user->name}}!

    Thank you for subscribing to our newsletter! We'll keep you updated with the latest news and offers.

    If you have any questions, feel free to reach out.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
