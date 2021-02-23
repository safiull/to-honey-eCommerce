{{-- <h1>Dear {{ $user_name }} your password change successfully!</h1> --}}
@component('mail::message')
# Dear {{ $user_name }} your password change successfully!

Your order has been shipped!

@component('mail::button', ['url' => 'shafiull.live'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent