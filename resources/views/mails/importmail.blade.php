@component('mail::message')
# Hi {{ $details['user']->first_name}} {{ $details['user']->last_name}},

@component('mail::panel')
@if($details['errors_count'] > 0)
<p>A few errors have occurred during your last import. Please refer the attachment which contains the skipped records of
    your import.</p>
@else
<p>All the records were successfully saved in your last import.</p>
@endif
@endcomponent
@component('mail::table')
| Successfull Imports | Skipped Imports |
| :----: |:----:|
|{{ $details['success_count'] }} rows.|{{ $details['errors_count'] }} rows.|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
