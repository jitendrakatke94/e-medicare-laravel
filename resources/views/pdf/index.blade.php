<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    /* @font-face {
        font-family: 'Open Sans', sans-serif;
        src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
    } */

    @page {
        margin: 0;
        margin-top: 180px;
        margin-bottom: 45px;
    }

    header {
        position: fixed;
        left: 0px;
        top: -180px;
        right: 0
    }

    footer {
        position: fixed;
        left: 0px;
        bottom: 35px;
        right: 0px;
    }

    * {
        box-sizing: border-box;
        font-family: 'Open Sans', sans-serif;
    }

    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    body {
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
    }

    th,
    td {
        padding: 0;
        vertical-align: top;
        text-align: left;
    }
</style>

<body>
    @php
    $logoPath = public_path("/images/logo.png");
    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPath);
    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp
    <header>
        <div style="width:100%;background-color:rgb(62, 103, 243);padding: 20px 40px;color:#fff">
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">
                            <img src="{{$logo}}" width="200" height="50" />
                        </td>
                        <td style="text-align:right;">
                            <h3 style="font-weight:bold;margin-bottom:10px;">Dr.
                                {{$prescription->appointment->doctor->first_name}}
                                {{$prescription->appointment->doctor->last_name}}</h3>
                            <p style="font-size: 15px;margin-bottom:6px;">
                                @foreach ($prescription->appointment->doctorinfo->specialization as $item)
                                {{$item['name']}},
                                @endforeach
                                <br>
                                {{$prescription->appointment->doctorinfo->qualification}},
                                <br>
                                @if(!is_null($prescription->appointment->doctorinfo->registration_number))
                                Registration Number -
                                {{$prescription->appointment->doctorinfo->registration_number}},
                                <br>
                                @endif
                                @if(!is_null($prescription->appointment->clinic_address))

                                {{$prescription->appointment->clinic_address->clinic_name}}
                                {{$prescription->appointment->clinic_address->street_name}},
                                {{$prescription->appointment->clinic_address->city_village}},
                                {{$prescription->appointment->clinic_address->district}},
                                {{$prescription->appointment->clinic_address->state}} -
                                {{$prescription->appointment->clinic_address->pincode}},
                                {{$prescription->appointment->clinic_address->country}}</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <footer>
        <p style="text-align:justify;color: rgb(94, 94, 94);font-size:12px;padding:0 20px">
            <b>Disclaimer:</b> This prescription is filled electronically by the registered medical professional for in
            clinic or online appointment. This can't be used for medico legal purpose. You completely understand and
            agree that Fogaat Healthcare Private Limited,
            on behalf of itself and its affiliates/group companies under the brand "emedicare" (“emedicare.in”), is not
            responsible or liable for any claim, loss, or damage resulting from its use by you or any user. Please read
            carefully our Terms & Conditions, Privacy Policy & all policies related documents on our website/app Home
            Page.
        </p>
    </footer>
    <main>
        <div style="width:100%;">
            <div style="width:100%;padding: 20px 40px;">
                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p style="font-size: 15px;margin-bottom:8px; color: rgb(94, 94, 94)">
                                    {{$prescription->unique_id}}</p>
                                <h3 style="margin-bottom:8px;">
                                    {{$prescription->appointment->patient_info['first_name']}}
                                    {{$prescription->appointment->patient_info['last_name']}}</h3>
                                <p><span>Age - {{$prescription->info['age']}} Y</span>
                                    <p>
                                        @if (!empty($prescription->appointment->current_patient_info['address']))
                                        <p><span>Address -
                                                {{$prescription->appointment->current_patient_info['address']->street_name}},
                                                {{$prescription->appointment->current_patient_info['address']->city_village}},
                                                {{$prescription->appointment->current_patient_info['address']->district}},
                                                {{$prescription->appointment->current_patient_info['address']->state}},
                                                {{$prescription->appointment->current_patient_info['address']->pincode}},
                                                {{$prescription->appointment->current_patient_info['address']->country}}
                                            </span>
                                            <p>
                                                @endif
                                                <p>Mobile Number :
                                                    {{$prescription->appointment->current_patient_info['info']['country_code']}}
                                                    {{$prescription->appointment->current_patient_info['info']['mobile_number']}}
                                                </p>

                            </td>
                            <td style="text-align:right;">
                                <p>{{ Carbon\Carbon::parse($prescription->created_at)->format('d-M-Y') }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Case Summary</h3>
                <p style="font-size: 15px;">{{$prescription->info['case_summary']}}</p>
            </div>
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Sx - Current Symptoms</h3>
                <p style="font-size: 15px;">{{$prescription->info['symptoms']}}</p>
            </div>
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Dx - Current Diagnosis</h3>
                <p style="font-size: 15px;">{{$prescription->info['diagnosis']}}</p>
            </div>
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <table style="width:100%;">
                    <thead style="background-color:rgb(242, 242, 253);">
                        <tr>
                            <th style="padding:10px;">Height</th>
                            <th style="padding:10px;">Weight</th>
                            <th style="padding:10px;">Body Temperature</th>
                            <th style="padding:10px;">Pulse Rate</th>
                            <th style="padding:10px;">BP Systolic</th>
                            <th style="padding:10px;">BP Diastolic</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['height']))
                                {{$prescription->info['height']}} cm
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['weight']))
                                {{$prescription->info['weight']}} kg
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['body_temp']))
                                {{$prescription->info['body_temp']}} &deg;C
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['pulse_rate']))
                                {{$prescription->info['pulse_rate']}} BPM
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['bp_diastolic']))
                                {{$prescription->info['bp_diastolic']}} mmHg
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                            <td style="padding:8px 10px;">
                                @if (!is_null($prescription->info['bp_systolic']))
                                {{$prescription->info['bp_systolic']}} mmHg
                                @else
                                {{'NA'}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if($prescription->medicinelist->isNotEmpty())
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Rx - Medicines</h3>
                <table style="width:100%;">
                    <thead style="background-color:rgb(242, 242, 253);">
                        <tr>
                            <th style="padding:10px;">No.</th>
                            <th style="padding:10px;">Name</th>
                            <th style="padding:10px;">Dosage Instructions</th>
                            <th style="padding:10px;">Duration</th>
                            <th style="padding:10px;">Instructions</th>
                            <th style="padding:10px;">No of Refill</th>
                            <th style="padding:10px;">Substitution Allowed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescription->medicinelist as $key=>$medicinelist)
                        <tr>
                            <td style="padding:8px 10px;">{{$key+1}}</td>
                            <td style="padding:8px 10px;">{{$medicinelist->medicine_name}}</td>
                            <td style="padding:8px 10px;">{{$medicinelist->dosage}}</td>
                            <td style="padding:8px 10px;">{{$medicinelist->duration}}</td>
                            <td style="padding:8px 10px;">{{$medicinelist->instructions}}</td>
                            <td style="padding:8px 10px;">{{$medicinelist->no_of_refill}}</td>
                            <td style="padding:8px 10px;">
                                @if ($medicinelist->substitution_allowed==0)
                                No
                                @else
                                Yes
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            @if($prescription->testlist->isNotEmpty())
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Lab Tests</h3>
                <table style="width:100%;">
                    <thead style="background-color:rgb(242, 242, 253)">
                        <tr>
                            <th style="padding:10px;">No.</th>
                            <th style="padding:10px;">Name</th>
                            <th style="padding:10px;">Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescription->testlist as $key=>$testlist)
                        <tr>
                            <td style="padding:8px 10px;">{{$key+1}}</td>
                            <td style="padding:8px 10px;">{{$testlist->test_name}}</td>
                            <td style="padding:8px 10px;">{{$testlist->instructions}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Diet Instructions</h3>
                <p style="font-size: 15px;">{{$prescription->info['diet_instruction']}}</p>
            </div>
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">General Instructions</h3>
                <p style="font-size: 15px;">{{$prescription->info['note_to_patient']}}</p>
            </div>
            <hr style="border-width:0;border-top:1px solid rgb(192, 192, 192);" />
            <div style="width:100%;padding: 10px 40px 20px 40px">
                @if (!is_null($prescription->appointment->followup_date))
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Next Followup Date</h3>
                <p style="font-size: 15px;">1.
                    {{ Carbon\Carbon::parse($prescription->appointment->followup_date)->format('d-M-Y') }}
                </p>
                @else
                @if(!empty($prescription->appointment->followup_one))
                <h3 style="font-weight:normal; color: rgb(94, 94, 94); margin-bottom: 10px;">Next Followup Date</h3>
                <p style="font-size: 15px;">1.
                    {{ Carbon\Carbon::parse($prescription->appointment->followup_one->followup_date)->format('d-M-Y') }}
                </p>
                @endif
                @endif

                <div style="width:100%;text-align:right;padding: 20px 0;">
                    <h3 style="font-weight:bold;margin-bottom:10px;">Dr.
                        {{$prescription->appointment->doctor->first_name}}
                        {{$prescription->appointment->doctor->last_name}}</h3>
                    <p style="font-size: 15px;">{{$prescription->appointment->doctorinfo->qualification}}</p>
                </div>
            </div>
        </div>
    </main>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
