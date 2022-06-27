@component('mail::message')

@component('mail::panel')

    {{$record['doctor']['first_name']}}, A new appointment has been scheduled on E-Medicare.
    Patient Name: {{$record['current_patient_info']['user']['first_name']}} {{$record['current_patient_info']['user']['last_name']}}
    Booking ID: {{$record['appointment_unique_id']}}
    Type: {{$record['consultation_type']}}
    Date: {{$record['booking_date']}} {{$record['time']}}
    Clinic: {{$record['clinic_address']['clinic_name']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent