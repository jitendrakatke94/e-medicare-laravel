@component('mail::message')

Hi {{ $details['user_name'] }},

@component('mail::panel')
{{$details['message']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
