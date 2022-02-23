<?php

namespace App\Jobs;

use App\Model\QuoteRequest;
use App\Model\Appointments;
use App\Model\Followups;
use App\Model\PrescriptionMedList;
use App\Model\Prescriptions;
use App\Model\PrescriptionTestList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PrescriptionPDFJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $prescription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Prescriptions $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //create medicine list
        try {
            $pharma_list = $laboratory_list = array();
            if (!empty($this->prescription->medicine_list)) {
                $pharma_list = array();
                foreach ($this->prescription->medicine_list as $key => $med_list) {
                    $prescriptionMedList = PrescriptionMedList::firstOrCreate(
                        [
                            'prescription_id' => $this->prescription->id,
                            'medicine_id' => $med_list['medicine_id'],
                        ],
                        [
                            'prescription_id' => $this->prescription->id,
                            'medicine_id' => $med_list['medicine_id'],
                            'dosage' => $med_list['dosage'],
                            'instructions' => $med_list['instructions'],
                            'duration' => $med_list['duration'],
                            'no_of_refill' => $med_list['no_of_refill'],
                            'substitution_allowed' => $med_list['substitution_allowed'],
                            'status' => $med_list['status'],
                            'note' => $med_list['note'],
                        ]
                    );
                    if ($med_list['status'] == 1) { // grouping pharmacies

                        if (array_key_exists($med_list['pharmacy_id'], $pharma_list)) {
                            $pharma_list[$med_list['pharmacy_id']][]
                                = $med_list['medicine_id'];
                        } else {
                            $pharma_list[$med_list['pharmacy_id']] = array($med_list['medicine_id']);
                        }
                        $prescriptionMedList->quote_generated = 1;
                        $prescriptionMedList->save();
                    } else if ($med_list['status'] == 0) {
                        $prescriptionMedList->quote_generated = 1;
                        $prescriptionMedList->save();
                    }
                }

                foreach ($pharma_list as $pharmacy_id => $medicine_list_new) {
                    //make quote request
                    $this->makeEntryForQuoteRequest($this->prescription->id, 'MED', $pharmacy_id, $medicine_list_new);
                }
            }
            // create test list
            if (!empty($this->prescription->test_list)) {
                $laboratory_list = array();
                foreach ($this->prescription->test_list as $key => $test) {
                    $prescriptionTestList = PrescriptionTestList::firstOrCreate(
                        [
                            'prescription_id' => $this->prescription->id,
                            'lab_test_id' => $test['test_id'],
                        ],
                        [
                            'prescription_id' => $this->prescription->id,
                            'lab_test_id' => $test['test_id'],
                            'instructions' => $test['instructions'],
                            'status' => $test['status'],
                            'note' => $test['note'],
                        ]
                    );
                    if ($test['status'] == 1) { //grouping laboratory
                        //make quote request
                        if (array_key_exists($test['laboratory_id'], $laboratory_list)) {
                            $laboratory_list[$test['laboratory_id']][]
                                = $test['test_id'];
                        } else {
                            $laboratory_list[$test['laboratory_id']] = array($test['test_id']);
                        }
                        $prescriptionTestList->quote_generated = 1;
                        $prescriptionTestList->save();
                    } else if ($test['status'] == 0) {
                        $prescriptionTestList->quote_generated = 1;
                        $prescriptionTestList->save();
                    }
                }

                foreach ($laboratory_list as $laboratory_id => $test_list_new) {
                    //make quote request
                    $this->makeEntryForQuoteRequest($this->prescription->id, 'LAB', $laboratory_id, $test_list_new);
                }
            }

            // create followup for appointment
            $appointment = Appointments::with('doctor')->with('doctorinfo')->find($this->prescription->appointment_id);
            // make followups for this appointments
            if (!is_null($appointment->doctorinfo->no_of_followup) && !is_null($appointment->doctorinfo->followups_after)) {

                // check if followup is present or else create new folloup
                if (is_null($appointment->followup_id)) {
                    $this->createFollowup(1, $appointment, $appointment->id);
                } else {
                    // follow up id is present
                    $followups = Followups::withTrashed()->withCount('parent')->find($appointment->followup_id);
                    $followups->makeVisible('parent_id');
                    $count = $followups->parent_count;

                    if ($count < $appointment->doctorinfo->no_of_followup) {
                        $this->createFollowup($count + 1, $appointment, $followups->parent_id);
                    }
                }
            }

            $this->generatePdfForPrescription($this->prescription->id);
            return;
        } catch (\Exception $e) {
            Log::error(['PDFJOBEXCEPTION' => $e->getMessage()]);
            return;
        }
    }
    public function createFollowup($i, $appointment, $parent_id)
    {
        Followups::firstOrCreate(
            [
                'appointment_id' => $appointment->id,
                'followup_date' => now()->addWeek($i * $appointment->doctorinfo->followups_after),
            ],
            [
                'appointment_id' => $appointment->id,
                'followup_date' => now()->addWeeks($i * $appointment->doctorinfo->followups_after),
                'doctor_id' => $appointment->doctor_id,
                'patient_id' => $appointment->patient_id,
                'clinic_id' => $appointment->address_id,
                'last_vist_date' => $appointment->date,
                'parent_id' => $parent_id,
            ]
        );
        Log::debug('PrescriptionPDFJob createFollowup', ['appointment_id' => $appointment->id, 'parent_id' => $parent_id]);
        return;
    }
    public function generatePdfForPrescription($prescription_id)
    {
        try {

            Log::debug('PrescriptionPDFJob', ['function' => 'generatePdfForPrescription']);

            $prescription = Prescriptions::with('medicinelist')->with('testlist')->with('appointment')->with('appointment.doctor')->with('appointment.doctorinfo')->with('appointment.doctorinfo.specialization')->with('appointment.followup_one')->with('appointment.clinic_address')->find($prescription_id);

            $pdf = \PDF::loadView(
                'pdf.index',
                compact('prescription')
            );
            $filePath = 'public/uploads/prescription/' . $prescription->id . '-' . time() . '.pdf';
            \Storage::put($filePath, $pdf->output());
            $prescription->file_path = $filePath;
            //$prescription->is_quote_generated = 1;
            $prescription->save();
            return;
        } catch (\Exception $exception) {
            Log::debug('PrescriptionPDFJob', ['EXCEPTION' => $exception->getMessage()]);
            return;
        }
    }
    public function makeEntryForQuoteRequest($prescription_id, $type, $pharma_lab_id, $list)
    {
        Log::debug('PrescriptionPDFJob', ['function' => '====================LOGPARAMS==============', 'prescription_id' => $prescription_id, 'type' => $type, 'pharma_lab_id' => $pharma_lab_id, 'quote_details' => $list]);

        QuoteRequest::create(
            [
                'prescription_id' => $prescription_id,
                'pharma_lab_id' => $pharma_lab_id,
                'unique_id' => $this->getQuoteRequestId(),
                'type' => $type,
                'status' => '0',
                'quote_type' => '1',
                'quote_details' => $list
            ]
        );
        return;
    }

    public function getQuoteRequestId()
    {
        try {
            $record = QuoteRequest::orderBy('id', 'desc')->withTrashed()->firstOrFail();
            //length of zero 7
            $record_id = 'QR' . sprintf("%07d", ($record->id + 1));
            return $record_id;
        } catch (\Exception $exception) {

            return 'QR0000001';
        }
    }
}
