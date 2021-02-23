@component('mail::message')
# Hello dear customer

@component('mail::panel')
Dear customer please come in our shop for got a wonderfull discount in our all products
@endcomponent

@component('mail::button', ['url' => 'shafiull.live'])
Check offers
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent