<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\PrescriptionPDFJob;
use App\Model\Address;
use App\Model\Appointments;
use App\Model\Prescriptions;
use App\Model\Quotes;
use App\Model\Role;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function makePdf()
    {
        return 403;

        // print_r(asset('/pdf/style.css'));
        // die();

        // $prescription = Prescriptions::where('is_quote_generated', 0)->whereHas('appointment', function ($query) {
        //     $query->where('is_completed', 1);
        //     $query->with('clinic');
        // })->first();

        $prescription = Prescriptions::with('medicinelist')->with('testlist')->with('appointment')->with('appointment.doctor')->with('appointment.doctorinfo')->with('appointment.doctorinfo.specialization')->with('appointment.followup')->find(1);


        //$app = Appointments::with('followup')->find(1);
        // foreach ($prescription as $key => $value) {
        //     # code...
        // }
        return response()->json($prescription, 200);

        // print_r($prescription);
        // die();
        // $appointment = Appointments::with('doctor')->with('patient')->with('doctorinfo')->with('patientinfo')->with('clinic')->with('patient')->find(1);
        // $doctor_address = Address::find($appointment->clinic->address_id);
        // $patient_address = Address::where('user_id', $prescription->patient_id)->first();

        // foreach ($prescription->medicine_list as $key => $medicine_list) {

        //     print_r($medicine_list['comment']);
        //     # code...
        // }

        // die();
        //print_r($appointment);
        $pdf = \PDF::loadView(
            'pdf.index',
            compact('prescription')
        );

        \Storage::put('/public/uploads/prescription/2.pdf', $pdf->output());

        return response()->json($prescription, 200);


        die();





        // share data to view
        //view()->share('pdf.index', $prescriptions);
        $pdf = \PDF::loadView('pdf.index', $prescription);

        \Storage::put('/public/uploads/prescription/1.pdf', $pdf->output());

        die('DIE');
        // download PDF file with download method
        //return $pdf->download('pdf_file.pdf');

        return view('pdf.index', compact('prescriptions'));
        print_r($prescriptions);
    }
}
