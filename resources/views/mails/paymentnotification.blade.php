@component('mail::message')

# Hi {{ $details['name'] }},

@component('mail::panel')
Below is the payment made to your account.

Amount paid : Rs.{{ $details['info']->amount }}.

Refrence Id : {{ $details['info']->reference }}

Comment : @if (!is_null($details['info']->comment)) {{$details['info']->comment}} @else -
@endif

@endcomponent

@component('mail::table')
| Payout Id | Cycle | Total payable | Total paid | Balance to be paid |
| -- |:----:| -----:| ---:| --------:|
|{{ $details['record']->payout_id }}|{{ $details['record']->period }}|{{ $details['record']->total_payable }}|{{ $details['record']->total_paid }}|{{ $details['record']->balance }}|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
