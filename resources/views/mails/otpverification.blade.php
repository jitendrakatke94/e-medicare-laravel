@component('mail::message')

Dear {{ $details['user_name'] }},


{!!$details['message']!!}

Best Regards<br><br>emedicare.in<br>Contact: 9999075725<br>Email: support@.in

<b>Disclaimer:</b> Internet communications are not secure and therefore emedicare does not accept legal responsibility
for the contents of this message. Any views or opinions presented are solely those of the author and do not necessarily
represent those of emedicare. The information in this email is intended only for the named recipient and may be
privileged or confidential. If you are not the intended recipient please notify us immediately on +919999075725 and do
not copy, distribute or take action based on this email.
@endcomponent
