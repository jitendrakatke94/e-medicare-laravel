@component('mail::message')

@component('mail::panel')
    Appointment Confirmed
    Hai Dr {{$record['doctor']['first_name']}}, New appointment confirmed for the following details.
    Patient Name: {{$record['current_patient_info']['user']['first_name']}} {{$record['current_patient_info']['user']['last_name']}}
    Bookingid: {{$record['appointment_unique_id']}}
    type: {{$record['consultation_type']}}
    Date: {{$record['booking_date']}} {{$record['time']}} 
    Place: {{$record['clinic_address']['clinic_name']}} {{$record['clinic_address']['street_name']}} {{$record['clinic_address']['city_village']}} {{$record['clinic_address']['state']}}.

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent