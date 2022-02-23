@component('mail::message')

# Hi {{ $details['name'] }},

@component('mail::panel')

{{$details['message']['message']}}

@if($details['credential']==1)

Your Login credentials are:

Username: {{$details['message']['user_name']}}

Password: {{$details['message']['password']}}

@endif
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
