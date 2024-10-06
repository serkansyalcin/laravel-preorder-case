{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}

@component('mail::message')
# Order Status

Hello {{ $user->first_name.' '.$user->last_name }},

Your order #{{ $order->order_number }} has been {{ $order->status }}!


@component('mail::table')
| Product Name | Price | Quantity |
| ------------- |:----:| --------:|
@foreach($order->orderItems as $item)
| {{ $item->product->name }} | {{ $item->price }} | {{ $item->qty }} |
@endforeach
@endcomponent


Thank you for shopping with us!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
