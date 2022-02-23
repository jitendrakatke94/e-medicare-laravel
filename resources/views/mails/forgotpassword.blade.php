@component('mail::message')

# Hi {{ $details['user_name'] }},

@component('mail::panel')
Your verification OTP for password reset is {{$details['message']}} , valid for 10 minutes.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
