@component('mail::message')

# Hi {{ $details['name'] }},

@component('mail::panel')

{{$details['message']}}

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
