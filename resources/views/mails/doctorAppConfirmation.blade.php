@component('mail::message')

# Hi {{ $doctor['username'] }},

@component('mail::panel')
Patient appointment is confirmed on date dd/mm/yyyy.

@endif

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent