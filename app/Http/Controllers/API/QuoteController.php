<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest as HttpQuoteRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\PrescriptionMedList;
use App\Model\Prescriptions;
use App\Model\PrescriptionTestList;
use App\Model\QuoteRequest;
use App\Model\Quotes;
use App\Model\TaxService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient Request Quote to pharmacy
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam prescription_id integer required
     * @bodyParam pharmacy_id array required
     * @bodyParam pharmacy_id.* integer required pharmacy id
     * @bodyParam medicine_list array required
     * @bodyParam medicine_list.* integer required medicine id
     *
     * @response 200 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "prescription_id": [
     *            "The prescription id field is required."
     *        ],
     *        "pharmacy_id": [
     *            "The pharmacy id field is required."
     *        ],
     *        "medicine_list.0": [
     *            "The medicine_list.0 field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Quote request sent successfully."
     *}
     */

    public function sendQuoteRequestPharmacy(HttpQuoteRequest $request)
    {
        $data = $request->validated();

        $prescription = Prescriptions::find($data['prescription_id']);
        $quote_type = '2';
        if ($prescription->purchase_type == 'Ecommerce') {
            $quote_type = '0';
        }

        foreach ($data['pharmacy_id'] as $key => $pharmacy_id) {
            QuoteRequest::create(
                [
                    'unique_id' => getQuoteRequestId(),
                    'status' => '0',
                    'quote_type' => $quote_type,
                    'prescription_id' => $data['prescription_id'],
                    'type' => 'MED',
                    'pharma_lab_id' => $pharmacy_id,
                    'quote_details' => $data['medicine_list']
                ]
            );
        }

        foreach ($request->medicine_list as $key => $medicine_id) {
            $list = PrescriptionMedList::where('prescription_id', $data['prescription_id'])->where('medicine_id', $medicine_id)->first();
            if ($list) {
                $list->quote_generated = 1;
                $list->save();
            }
        }
        return new SuccessMessage('Quote request sent successfully.');
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient Request Quote to laboratory
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam prescription_id integer required
     * @bodyParam laboratory_id array required
     * @bodyParam laboratory_id.* integer required laboratory id
     * @bodyParam test_list array required
     * @bodyParam test_list.* integer required test id
     *
     * @response 200 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "prescription_id": [
     *            "The prescription id field is required."
     *        ],
     *        "test_list": [
     *            "The test list field is required."
     *        ],
     *        "laboratory_id": [
     *            "The laboratory id field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Quote request sent successfully."
     *}
     */
    public function sendQuoteRequestLaboratory(HttpQuoteRequest $request)
    {
        $data = $request->validated();
        $prescription = Prescriptions::find($data['prescription_id']);
        $quote_type = '2';
        if ($prescription->purchase_type == 'Ecommerce') {
            $quote_type = '0';
        }
        foreach ($data['laboratory_id'] as $key => $laboratory_id) {
            QuoteRequest::create(
                [
                    'unique_id' => getQuoteRequestId(),
                    'status' => '0',
                    'quote_type' => $quote_type,
                    'prescription_id' => $data['prescription_id'],
                    'type' => 'LAB',
                    'pharma_lab_id' => $laboratory_id,
                    'quote_details' => $data['test_list']
                ]
            );
        }
        foreach ($request->test_list as $key => $test_list) {
            $list = PrescriptionTestList::where('prescription_id', $data['prescription_id'])->where('lab_test_id', $test_list)->first();
            if ($list) {
                $list->quote_generated = 1;
                $list->save();
            }
        }
        return new SuccessMessage('Quote request sent successfully.');
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get Quotes Request
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array
     * @queryParam filter.search nullable string present
     * @queryParam filter.doctor nullable string present
     * @queryParam filter.status nullable boolean present 0 or 1
     * @queryParam dispense_request nullable number send 1
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 59,
     *            "unique_id": "QR0000059",
     *            "prescription_id": 89,
     *            "quote_reply": null,
     *            "status": "0",
     *            "submission_date": null,
     *            "file_path": null,
     *            "created_at": "2021-02-10 09:55:20 pm",
     *            "medicine_list": [
     *                {
     *                    "id": 8,
     *                    "prescription_id": 13,
     *                    "medicine_id": 1,
     *                    "quote_generated": 1,
     *                    "dosage": "1 - 0 - 0 - 1",
     *                    "instructions": null,
     *                    "duration": "3 days",
     *                    "no_of_refill": "0",
     *                    "substitution_allowed": 1,
     *                    "medicine_status": "Dispensed outside.",
     *                    "medicine_name": "Ammu",
     *                    "medicine": {
     *                        "id": 1,
     *                        "category_id": 1,
     *                        "sku": "MED0000001",
     *                        "composition": "Paracetamol",
     *                        "weight": 50,
     *                        "weight_unit": "kg",
     *                        "name": "Ammu",
     *                        "manufacturer": "Ammu Corporation",
     *                        "medicine_type": "Drops",
     *                        "drug_type": "Branded",
     *                        "qty_per_strip": 10,
     *                        "price_per_strip": 45,
     *                        "rate_per_unit": 4.5,
     *                        "rx_required": 0,
     *                        "short_desc": "This is a good product",
     *                        "long_desc": "This is a good product",
     *                        "cart_desc": "This is a good product",
     *                        "image_name": null,
     *                        "image_url": null
     *                    }
     *                },
     *                {
     *                    "id": 9,
     *                    "prescription_id": 13,
     *                    "medicine_id": 4,
     *                    "quote_generated": 1,
     *                    "dosage": "1 - 0 - 0 - 1",
     *                    "instructions": null,
     *                    "duration": "3 days",
     *                    "no_of_refill": "3",
     *                    "substitution_allowed": 0,
     *                    "medicine_status": "Dispensed at associated pharmacy.",
     *                    "medicine_name": "Paraceta Test",
     *                    "medicine": {
     *                        "id": 4,
     *                        "category_id": 2,
     *                        "sku": "MED0000004",
     *                        "composition": "test data compo",
     *                        "weight": 170.56,
     *                        "weight_unit": "mg",
     *                        "name": "Paraceta Test",
     *                        "manufacturer": "Pfizer",
     *                        "medicine_type": "Suppositories",
     *                        "drug_type": "Branded",
     *                        "qty_per_strip": 5,
     *                        "price_per_strip": 100.3,
     *                        "rate_per_unit": 6,
     *                        "rx_required": 1,
     *                        "short_desc": null,
     *                        "long_desc": "null",
     *                        "cart_desc": null,
     *                        "image_name": null,
     *                        "image_url": null
     *                    }
     *                }
     *            ],
     *            "prescription": {
     *                "id": 89,
     *                "appointment_id": 248,
     *                "unique_id": "PX0000087",
     *                "created_at": "2021-02-10",
     *                "pdf_url": "http://localhost/fms-api-laravel/public/storage/uploads/prescription/89-1612974321.pdf",
     *                "status_medicine": "Yet to dispense.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "appointment": {
     *                    "id": 248,
     *                    "doctor_id": 2,
     *                    "patient_id": 47,
     *                    "appointment_unique_id": "AP0000248",
     *                    "date": "2021-02-11",
     *                    "time": "12:05:00",
     *                    "consultation_type": "ONLINE",
     *                    "shift": null,
     *                    "payment_status": null,
     *                    "transaction_id": null,
     *                    "total": null,
     *                    "is_cancelled": 0,
     *                    "is_completed": 1,
     *                    "followup_id": null,
     *                    "booking_date": "2021-02-10",
     *                    "current_patient_info": {
     *                        "user": {
     *                            "first_name": "Diana",
     *                            "middle_name": "Princess",
     *                            "last_name": "Wales",
     *                            "email": "diana@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "7878787878",
     *                            "profile_photo_url": null
     *                        },
     *                        "case": 1,
     *                        "info": {
     *                            "first_name": "Diana",
     *                            "middle_name": "Princess",
     *                            "last_name": "Wales",
     *                            "email": "diana@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "7878787878",
     *                            "height": 156,
     *                            "weight": 55,
     *                            "gender": "FEMALE",
     *                            "age": 23
     *                        },
     *                        "address": {
     *                            "id": 132,
     *                            "street_name": "Vadakkaparampill",
     *                            "city_village": "PATHANAMTHITTA",
     *                            "district": "Pathanamthitta",
     *                            "state": "Kerala",
     *                            "country": "India",
     *                            "pincode": "689667",
     *                            "country_code": null,
     *                            "contact_number": "+917591985087",
     *                            "latitude": null,
     *                            "longitude": null,
     *                            "clinic_name": null
     *                        }
     *                    },
     *                    "doctor": {
     *                        "id": 2,
     *                        "first_name": "Theophilus",
     *                        "middle_name": "Jos",
     *                        "last_name": "Simeon",
     *                        "email": "theophilus@logidots.com",
     *                        "username": "theo",
     *                        "country_code": "+91",
     *                        "mobile_number": "8940330536",
     *                        "user_type": "DOCTOR",
     *                        "is_active": "1",
     *                        "role": null,
     *                        "currency_code": "INR",
     *                        "approved_date": "2021-01-04",
     *                        "profile_photo_url": null
     *                    },
     *                    "clinic_address": {
     *                        "id": 1,
     *                        "street_name": "South Road",
     *                        "city_village": "Edamatto",
     *                        "district": "Kottayam",
     *                        "state": "Kerala",
     *                        "country": "India",
     *                        "pincode": "686575",
     *                        "country_code": null,
     *                        "contact_number": "9786200983",
     *                        "latitude": "10.53034500",
     *                        "longitude": "76.21472900",
     *                        "clinic_name": "Neo clinic"
     *                    }
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request?page=1",
     *    "from": 1,
     *    "last_page": 11,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request?page=11",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/pharmacy/quote/request",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 11
     *}
     * @response 404 {
     *    "message": "Quotes request not found."
     *}
     */
    public function getQuoteRequestPharmacy(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.search' => 'nullable|present',
            'filter.doctor' => 'nullable|present',
            'filter.status' => 'nullable|present|in:0,1,Dispensed,Not Dispensed',
            'dispense_request' => 'nullable|in:1'
        ]);

        $list = QuoteRequest::with('prescription')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->where('pharma_lab_id', auth()->user()->pharmacy->id)->where('type', 'MED');

        $status_column = 'status';
        if ($request->filled('dispense_request')) {
            $list = $list->where('quote_type', "1");
            $status_column = 'pharma_lab_status';
        } else {
            $list = $list->where('quote_type', '!=', "1");
        }

        $list = $list->where(function ($query) use ($validatedData, $status_column) {
            if (!is_null($validatedData['filter']['search'])) {

                if (strpos($validatedData['filter']['search'], 'QR') !== false) {
                    $query->where('unique_id', $validatedData['filter']['search']);
                }
            }
            if (!is_null($validatedData['filter']['status'])) {
                $query->where($status_column, $validatedData['filter']['status']);
            }
        });
        if (!is_null($validatedData['filter']['doctor'])) {
            $list = $list->whereHas('prescription.appointment.doctor', function ($query) use ($validatedData) {
                $query->orWhere('first_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
                $query->orWhere('middle_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
                $query->orWhere('last_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
            });
        }
        if (!is_null($validatedData['filter']['search']) && strpos($validatedData['filter']['search'], 'QR') === false) {
            $list = $list->whereHas(
                'prescription.appointment.clinic_address',
                function ($query) use ($validatedData) {
                    $query->where('clinic_name', 'like', '%' . $validatedData['filter']['search'] . '%');
                }
            );
        }
        $list = $list->with('prescription.appointment.doctor')->with('prescription.appointment.clinic_address')->orderBy('id', 'desc')->paginate(QuoteRequest::$page);

        if ($list->count() > 0) {
            $list->makeHidden('test_list');
            $result = $list->toArray();
            $datas = $result['data'];
            foreach ($datas as $key => $data) {
                unset($data['prescription']['info']);
                unset($data['prescription']['appointment']['patient_details']);
                unset($data['prescription']['appointment']['patient_more_info']);
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            $result['home_delivery'] = auth()->user()->pharmacy->home_delivery;
            $result['order_amount'] = auth()->user()->pharmacy->order_amount;
            return response()->json($result, 200);
        }
        return new ErrorMessage('Quotes request not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get Quotes
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 75,
     *            "created_at": "2021-03-02 09:12:58 pm",
     *            "unique_id": "QT0000076",
     *            "quote_request": {
     *                "created_at": "2021-02-12 12:01:26 am",
     *                "quote_type": null
     *            },
     *            "order": {
     *                "id": 1,
     *                "user_id": 3,
     *                "tax": 10,
     *                "subtotal": 20,
     *                "discount": 2,
     *                "delivery_charge": 2,
     *                "total": 500.49,
     *                "shipping_address_id": 1,
     *                "payment_status": "Not Paid",
     *                "delivery_status": "Open",
     *                "delivery_info": null,
     *                "created_at": "2021-03-02 06:29:02 pm"
     *            },
     *            "prescription": {
     *                "id": 114,
     *                "appointment_id": 285,
     *                "unique_id": "PX0000114",
     *                "created_at": "2021-02-11",
     *                "pdf_url": null,
     *                "status_medicine": "Quote generated.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "appointment": {
     *                    "id": 285,
     *                    "doctor_id": 2,
     *                    "patient_id": 3,
     *                    "appointment_unique_id": "AP0000285",
     *                    "date": "2021-02-11",
     *                    "time": "18:28:00",
     *                    "start_time": null,
     *                    "end_time": null,
     *                    "consultation_type": "ONLINE",
     *                    "shift": null,
     *                    "payment_status": null,
     *                    "transaction_id": null,
     *                    "total": null,
     *                    "tax": null,
     *                    "is_cancelled": 0,
     *                    "is_completed": 1,
     *                    "followup_id": null,
     *                    "booking_date": "2021-02-11",
     *                    "current_patient_info": {
     *                        "user": {
     *                            "first_name": "Ben",
     *                            "middle_name": null,
     *                            "last_name": "Patient",
     *                            "email": "patient@logidots.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "9876543210",
     *                            "profile_photo_url": null
     *                        },
     *                        "case": 2,
     *                        "info": {
     *                            "first_name": "James",
     *                            "middle_name": "s",
     *                            "last_name": "Bond",
     *                            "email": "patient@logidots.com",
     *                            "country_code": "+91",
     *                            "mobile_number": 9876543210,
     *                            "height": 0,
     *                            "weight": 0,
     *                            "gender": "MALE",
     *                            "age": 10
     *                        },
     *                        "address": {
     *                            "id": 36,
     *                            "street_name": "Sreekariyam",
     *                            "city_village": "Trivandrum",
     *                            "district": "Alappuzha",
     *                            "state": "Kerala",
     *                            "country": "India",
     *                            "pincode": "688001",
     *                            "country_code": null,
     *                            "contact_number": null,
     *                            "land_mark": null,
     *                            "latitude": null,
     *                            "longitude": null,
     *                            "clinic_name": null
     *                        }
     *                    },
     *                    "doctor": {
     *                        "id": 2,
     *                        "first_name": "Theophilus",
     *                        "middle_name": "Jos",
     *                        "last_name": "Simeon",
     *                        "email": "theophilus@logidots.com",
     *                        "username": "theo",
     *                        "country_code": "+91",
     *                        "mobile_number": "8940330536",
     *                        "user_type": "DOCTOR",
     *                        "is_active": "1",
     *                        "role": null,
     *                        "currency_code": "INR",
     *                        "approved_date": "2021-01-04",
     *                        "profile_photo_url": null
     *                    }
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote?page=1",
     *    "from": 1,
     *    "last_page": 11,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote?page=11",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/pharmacy/quote?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/pharmacy/quote",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 11
     *}
     *
     * @response 404 {
     *    "message": "Quotes not found."
     *}
     */
    public function getQuotePharmacy(Request $request)
    {
        $list = Quotes::where('pharma_lab_id', auth()->user()->pharmacy->id)->where('type', 'MED')->with('quote_request:id,created_at,quote_type,type,quote_details')->with('order')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->orderBy('created_at', 'desc')->paginate(Quotes::$page);
        if ($list->count() > 0) {
            $list->makeHidden('medicine');
            $list->makeHidden('test');
            $list->makeHidden('quote_from');
            $result = $list->toArray();
            $datas = $result['data'];
            foreach ($datas as $key => $data) {
                unset($data['quote_request']['id']);
                unset($data['quote_request']['type']);
                unset($data['quote_request']['medicine_list']);
                unset($data['quote_request']['test_list']);
                unset($data['quote_request']['prescription']);
                unset($data['prescription']['info']);
                unset($data['prescription']['prescription']);
                unset($data['prescription']['appointment']['patient_details']);
                unset($data['prescription']['appointment']['patient_more_info']);
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            return response()->json($result, 200);
        }
        return new ErrorMessage('Quotes not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get Quotes
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 72,
     *            "type": "LAB",
     *            "created_at": "2021-03-01 03:46:59 pm",
     *            "unique_id": "QT0000073",
     *            "quote_request": {
     *                "created_at": "2021-02-26 11:58:03 pm",
     *                "quote_type": "Added by doctor."
     *            },
     *            "order": {
     *                "id": 9,
     *                "user_id": 125,
     *                "tax": 10,
     *                "subtotal": 20,
     *                "discount": 2,
     *                "delivery_charge": 2,
     *                "total": 500.49,
     *                "shipping_address_id": 1,
     *                "payment_status": "Not Paid",
     *                "delivery_status": "Open",
     *                "delivery_info": null,
     *                "created_at": "2021-03-08 03:16:16 pm"
     *            },
     *            "prescription": {
     *                "id": 251,
     *                "appointment_id": 462,
     *                "unique_id": "PX0000251",
     *                "created_at": "2021-02-26",
     *                "pdf_url": null,
     *                "status_medicine": "Quote not generated.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "appointment": {
     *                    "id": 462,
     *                    "doctor_id": 121,
     *                    "patient_id": 123,
     *                    "appointment_unique_id": "AP0000462",
     *                    "date": "2021-02-26",
     *                    "time": "18:18:00",
     *                    "start_time": "18:18:00",
     *                    "end_time": "18:20:00",
     *                    "consultation_type": "ONLINE",
     *                    "shift": null,
     *                    "payment_status": null,
     *                    "transaction_id": null,
     *                    "total": null,
     *                    "tax": null,
     *                    "is_cancelled": 0,
     *                    "is_completed": 1,
     *                    "followup_id": null,
     *                    "booking_date": "2021-02-26",
     *                    "current_patient_info": {
     *                        "user": {
     *                            "first_name": "Beny",
     *                            "middle_name": "K",
     *                            "last_name": "Sebastian",
     *                            "email": "benyseba@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "9090871555",
     *                            "profile_photo_url": null
     *                        },
     *                        "case": 1,
     *                        "info": {
     *                            "first_name": "Beny",
     *                            "middle_name": "K",
     *                            "last_name": "Sebastian",
     *                            "email": "benyseba@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "9090871555",
     *                            "height": 150,
     *                            "weight": 60,
     *                            "gender": "MALE",
     *                            "age": 34
     *                        },
     *                        "address": {
     *                            "id": 162,
     *                            "street_name": "Gandhi nagar",
     *                            "city_village": "Central city",
     *                            "district": "Hyderabad",
     *                            "state": "Telangana",
     *                            "country": "India",
     *                            "pincode": "500001",
     *                            "country_code": null,
     *                            "contact_number": null,
     *                            "land_mark": null,
     *                            "latitude": null,
     *                            "longitude": null,
     *                            "clinic_name": null
     *                        }
     *                    },
     *                    "doctor": {
     *                        "id": 121,
     *                        "first_name": "Joji",
     *                        "middle_name": "S",
     *                        "last_name": "Thilak",
     *                        "email": "jojidev@gmail.com",
     *                        "username": "Joji",
     *                        "country_code": "+91",
     *                        "mobile_number": "8890786512",
     *                        "user_type": "DOCTOR",
     *                        "is_active": "1",
     *                        "role": null,
     *                        "currency_code": "INR",
     *                        "approved_date": "2021-02-12",
     *                        "profile_photo_url": null
     *                    }
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote?page=1",
     *    "from": 1,
     *    "last_page": 3,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote?page=3",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/laboratory/quote",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 3
     *}
     * @response 404 {
     *    "message": "Quotes not found."
     *}

     */
    public function getQuoteLaboratory(Request $request)
    {
        $list = Quotes::where('pharma_lab_id', auth()->user()->laboratory->id)->where('type', 'LAB')->with('quote_request:id,created_at,quote_type,type,quote_details')->with('order')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->orderBy('created_at', 'desc')->paginate(Quotes::$page);

        if ($list->count() > 0) {
            $list->makeHidden('medicine');
            $list->makeHidden('test');
            $list->makeHidden('quote_from');
            $result = $list->toArray();
            $datas = $result['data'];
            foreach ($datas as $key => $data) {
                unset($data['quote_request']['id']);
                unset($data['quote_request']['type']);
                unset($data['quote_request']['medicine_list']);
                unset($data['quote_request']['test_list']);
                unset($data['quote_request']['prescription']);
                unset($data['prescription']['info']);
                unset($data['prescription']['prescription']);
                unset($data['prescription']['appointment']['patient_details']);
                unset($data['prescription']['appointment']['patient_more_info']);
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            return response()->json($result, 200);
        }
        return new ErrorMessage('Quotes not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get Quotes by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of quote
     *
     * @response 200 {
     *    "id": 75,
     *    "created_at": "2021-03-02 09:12:58 pm",
     *    "unique_id": "QT0000076",
     *    "order": {
     *        "id": 5,
     *        "user_id": 3,
     *        "tax": 10,
     *        "subtotal": 20,
     *        "discount": 2,
     *        "delivery_charge": 2,
     *        "total": 500.49,
     *        "shipping_address_id": 1,
     *        "payment_status": "Not Paid",
     *        "delivery_status": "Open",
     *        "delivery_info": null,
     *        "created_at": "2021-03-04 12:07:08 am",
     *        "billing_address": [
     *            {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamatto",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": "9786200983",
     *                "land_mark": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "Neo clinic"
     *            }
     *        ],
     *        "payments": {
     *            "id": 1,
     *            "unique_id": "PAY0000001",
     *            "total_amount": 500.49,
     *            "payment_status": "Not Paid",
     *            "created_at": "2021-03-04 12:07:08 am"
     *        }
     *    },
     *    "prescription": {
     *        "id": 114,
     *        "appointment_id": 285,
     *        "unique_id": "PX0000114",
     *        "created_at": "2021-02-11",
     *        "pdf_url": null,
     *        "patient": {
     *             "id": 22,
     *             "first_name": "Vishnu",
     *             "middle_name": "S",
     *             "last_name": "Sharma",
     *             "email": "vishnusharmatest123@yopmail.com",
     *             "country_code": "+91",
     *             "mobile_number": "3736556464",
     *             "profile_photo_url": null
     *         },
     *        "status_medicine": "Quote generated.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *        "appointment": {
     *            "id": 285,
     *            "doctor_id": 2,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000285",
     *            "date": "2021-02-11",
     *            "time": "18:28:00",
     *            "start_time": null,
     *            "end_time": null,
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "tax": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "razorpay_payment_id": null,
     *            "razorpay_order_id": null,
     *            "razorpay_signature": null,
     *            "booking_date": "2021-02-11",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Ben",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "profile_photo_url": null
     *                },
     *                "case": 2,
     *                "info": {
     *                    "first_name": "James",
     *                    "middle_name": "s",
     *                    "last_name": "Bond",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": 9876543210,
     *                    "height": 0,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 10
     *                }
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": "INR",
     *                "approved_date": "2021-01-04",
     *                "profile_photo_url": null
     *            }
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     */
    public function getQuotePharmacyById($id)
    {
        try {
            $record = Quotes::where('pharma_lab_id', auth()->user()->pharmacy->id)->where('type', 'MED')->where('id', $id)->with('order')->with('order.billing_address')->with('order.payments')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->firstOrFail();
            $record->makeHidden('medicine');
            $record->makeHidden('test');
            $record->makeHidden('quote_from');

            $result = $record->toArray();
            unset($result['prescription']['info']);
            unset($result['prescription']['prescription']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['appointment']['current_patient_info']['address']);
            unset($result['prescription']['medicinelist']);
            unset($result['prescription']['testlist']);
            return response()->json($result, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get Quotes by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of quote
     *
     * @response 200 {
     *    "id": 71,
     *    "type": "LAB",
     *    "created_at": "2021-02-27 01:34:17 am",
     *    "unique_id": "QT0000072",
     *    "order": {
     *        "id": 8,
     *        "user_id": 125,
     *        "tax": 10,
     *        "subtotal": 20,
     *        "discount": 2,
     *        "delivery_charge": 2,
     *        "total": 500.49,
     *        "shipping_address_id": 1,
     *        "payment_status": "Not Paid",
     *        "delivery_status": "Open",
     *        "delivery_info": null,
     *        "created_at": "2021-03-08 03:05:07 pm",
     *        "billing_address": [
     *            {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamatto",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": "9786200983",
     *                "land_mark": null,
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "Neo clinic"
     *            }
     *        ],
     *        "payments": {
     *            "id": 5,
     *            "unique_id": "PAY0000005",
     *            "total_amount": 500.49,
     *            "payment_status": "Not Paid",
     *            "created_at": "2021-03-08 03:05:07 pm"
     *        }
     *    },
     *    "prescription": {
     *        "id": 257,
     *        "appointment_id": 460,
     *        "unique_id": "PX0000257",
     *        "created_at": "2021-02-26",
     *        "pdf_url": null,
     *        "patient": {
     *            "id": 22,
     *            "first_name": "Vishnu",
     *            "middle_name": "S",
     *            "last_name": "Sharma",
     *            "email": "vishnusharmatest123@yopmail.com",
     *            "country_code": "+91",
     *            "mobile_number": "3736556464",
     *            "profile_photo_url": null
     *        },
     *        "status_medicine": "Quote generated.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *        "appointment": {
     *            "id": 460,
     *            "doctor_id": 121,
     *            "patient_id": 123,
     *            "appointment_unique_id": "AP0000460",
     *            "date": "2021-02-26",
     *            "time": "18:43:00",
     *            "start_time": "18:43:00",
     *            "end_time": "18:45:00",
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "tax": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-02-26",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Beny",
     *                    "middle_name": "K",
     *                    "last_name": "Sebastian",
     *                    "email": "benyseba@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9090871555",
     *                    "profile_photo_url": null
     *                },
     *                "case": 1,
     *                "info": {
     *                    "first_name": "Beny",
     *                    "middle_name": "K",
     *                    "last_name": "Sebastian",
     *                    "email": "benyseba@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9090871555",
     *                    "height": 150,
     *                    "weight": 60,
     *                    "gender": "MALE",
     *                    "age": 34
     *                }
     *            },
     *            "doctor": {
     *                "id": 121,
     *                "first_name": "Joji",
     *                "middle_name": "S",
     *                "last_name": "Thilak",
     *                "email": "jojidev@gmail.com",
     *                "username": "Joji",
     *                "country_code": "+91",
     *                "mobile_number": "8890786512",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": "INR",
     *                "approved_date": "2021-02-12",
     *                "profile_photo_url": null
     *            }
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     */
    public function getQuoteLaboratoryById($id)
    {
        try {
            $record = Quotes::where('pharma_lab_id', auth()->user()->laboratory->id)->where('type', 'LAB')->where('id', $id)->with('order')->with('order.billing_address')->with('order.payments')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->firstOrFail();
            $record->makeHidden('medicine');
            $record->makeHidden('test');
            $record->makeHidden('quote_from');

            $result = $record->toArray();
            unset($result['prescription']['info']);
            unset($result['prescription']['prescription']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['appointment']['current_patient_info']['address']);
            unset($result['prescription']['medicinelist']);
            unset($result['prescription']['testlist']);
            return response()->json($result, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get Quotes Request by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam quote_request_id required integer id of quote_request object
     *
     * @response 200 {
     *    "id": 59,
     *    "unique_id": "QR0000059",
     *    "prescription_id": 89,
     *    "quote_reply": null,
     *    "status": "0",
     *    "submission_date": null,
     *    "file_path": null,
     *    "created_at": "2021-02-10 09:55:20 pm",
     *    "medicine_list": [
     *        {
     *            "id": 8,
     *            "prescription_id": 13,
     *            "medicine_id": 1,
     *            "quote_generated": 1,
     *            "dosage": "1 - 0 - 0 - 1",
     *            "instructions": null,
     *            "duration": "3 days",
     *            "no_of_refill": "0",
     *            "substitution_allowed": 1,
     *            "medicine_status": "Dispensed outside.",
     *            "medicine_name": "Ammu",
     *            "medicine": {
     *                "id": 1,
     *                "category_id": 1,
     *                "sku": "MED0000001",
     *                "composition": "Paracetamol",
     *                "weight": 50,
     *                "weight_unit": "kg",
     *                "name": "Ammu",
     *                "manufacturer": "Ammu Corporation",
     *                "medicine_type": "Drops",
     *                "drug_type": "Branded",
     *                "qty_per_strip": 10,
     *                "price_per_strip": 45,
     *                "rate_per_unit": 4.5,
     *                "rx_required": 0,
     *                "short_desc": "This is a good product",
     *                "long_desc": "This is a good product",
     *                "cart_desc": "This is a good product",
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        },
     *        {
     *            "id": 9,
     *            "prescription_id": 13,
     *            "medicine_id": 4,
     *            "quote_generated": 1,
     *            "dosage": "1 - 0 - 0 - 1",
     *            "instructions": null,
     *            "duration": "3 days",
     *            "no_of_refill": "3",
     *            "substitution_allowed": 0,
     *            "medicine_status": "Dispensed at associated pharmacy.",
     *            "medicine_name": "Paraceta Test",
     *            "medicine": {
     *                "id": 4,
     *                "category_id": 2,
     *                "sku": "MED0000004",
     *                "composition": "test data compo",
     *                "weight": 170.56,
     *                "weight_unit": "mg",
     *                "name": "Paraceta Test",
     *                "manufacturer": "Pfizer",
     *                "medicine_type": "Suppositories",
     *                "drug_type": "Branded",
     *                "qty_per_strip": 5,
     *                "price_per_strip": 100.3,
     *                "rate_per_unit": 6,
     *                "rx_required": 1,
     *                "short_desc": null,
     *                "long_desc": "null",
     *                "cart_desc": null,
     *                "image_name": null,
     *                "image_url": null
     *            }
     *        }
     *    ],
     *    "prescription": {
     *        "id": 89,
     *        "appointment_id": 248,
     *        "unique_id": "PX0000087",
     *        "created_at": "2021-02-10",
     *        "pdf_url": "http://localhost/fms-api-laravel/public/storage/uploads/prescription/89-1612974321.pdf",
     *        "status_medicine": "Yet to dispense.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *        "appointment": {
     *            "id": 248,
     *            "doctor_id": 2,
     *            "patient_id": 47,
     *            "appointment_unique_id": "AP0000248",
     *            "date": "2021-02-11",
     *            "time": "12:05:00",
     *            "consultation_type": "ONLINE",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-02-10",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Diana",
     *                    "middle_name": "Princess",
     *                    "last_name": "Wales",
     *                    "email": "diana@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "7878787878",
     *                    "profile_photo_url": null
     *                },
     *                "case": 1,
     *                "info": {
     *                    "first_name": "Diana",
     *                    "middle_name": "Princess",
     *                    "last_name": "Wales",
     *                    "email": "diana@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "7878787878",
     *                    "height": 156,
     *                    "weight": 55,
     *                    "gender": "FEMALE",
     *                    "age": 23
     *                },
     *                "address": {
     *                    "id": 132,
     *                    "street_name": "Vadakkaparampill",
     *                    "city_village": "PATHANAMTHITTA",
     *                    "district": "Pathanamthitta",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "689667",
     *                    "country_code": null,
     *                    "contact_number": "+917591985087",
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": "INR",
     *                "approved_date": "2021-01-04",
     *                "profile_photo_url": null
     *            },
     *            "clinic_address": {
     *                "id": 1,
     *                "street_name": "South Road",
     *                "city_village": "Edamatto",
     *                "district": "Kottayam",
     *                "state": "Kerala",
     *                "country": "India",
     *                "pincode": "686575",
     *                "country_code": null,
     *                "contact_number": "9786200983",
     *                "latitude": "10.53034500",
     *                "longitude": "76.21472900",
     *                "clinic_name": "Neo clinic"
     *            }
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     */
    public function getQuoteRequestPharmacyById($id)
    {
        try {
            $record = QuoteRequest::with('prescription')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->with('prescription.appointment.clinic_address')->where('id', $id)->where('type', 'MED')->firstOrFail();
            $record->makeHidden('test_list');
            $result = $record->toArray();
            unset($result['prescription']['info']);
            unset($result['prescription']['info']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['medicinelist']);

            $result['home_delivery'] = auth()->user()->pharmacy->home_delivery;
            $result['order_amount'] = auth()->user()->pharmacy->order_amount;
            return response()->json($result, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy edit Quotes Request by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_request_id required integer id of quote request
     * @bodyParam status required string send -> Dispensed
     *
     *  @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "quote_request_id": [
     *            "The quote request id field is required."
     *        ],
     *        "status": [
     *            "The status field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Updated successfully."
     *}
     */
    public function editQuoteRequestPharmacyById(Request $request)
    {
        $data = $request->validate([
            'quote_request_id' => 'required|exists:quote_requests,id,deleted_at,NULL,type,MED,pharma_lab_status,Not Dispensed,pharma_lab_id,' . auth()->user()->pharmacy->id,
            'status' => 'required|in:Dispensed'
        ]);

        $record = QuoteRequest::find($data['quote_request_id']);
        $record->pharma_lab_status = $data['status'];
        $record->status = '1';
        $record->save();

        return new SuccessMessage('Updated successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory edit Quotes Request by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_request_id required integer id of quote request
     * @bodyParam status required string send -> Dispensed
     * @bodyParam bill_number string present
     * @bodyParam bill_amount numeric present
     * @bodyParam bill_date date present format -> Y-m-d
     *
     *  @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "quote_request_id": [
     *            "The quote request id field is required."
     *        ],
     *        "status": [
     *            "The status field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Updated successfully."
     *}
     */
    public function editQuoteRequestLaboratoryById(Request $request)
    {
        $data = $request->validate([
            'quote_request_id' => 'required|exists:quote_requests,id,deleted_at,NULL,type,LAB,pharma_lab_status,Not Dispensed,pharma_lab_id,' . auth()->user()->laboratory->id,
            'status' => 'required|in:Dispensed',
            'bill_number' => 'present|nullable',
            'bill_amount' => 'present|nullable|numeric',
            'bill_date' => 'present|nullable|date_format:Y-m-d',

        ]);

        $record = QuoteRequest::find($data['quote_request_id']);
        $record->pharma_lab_status = $data['status'];
        $record->status = '1';
        $record->bill_number = $request->bill_number;
        $record->bill_amount = $request->bill_amount;
        $record->bill_date = $request->bill_date;
        $record->save();

        return new SuccessMessage('Updated successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get Quotes Request by Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam quote_request_id required integer id of quote_request object
     *
     * @response 200 {
     *    "id": 2,
     *    "unique_id": "QR0000002",
     *    "prescription_id": 1,
     *    "quote_reply": null,
     *    "status": "0",
     *    "submission_date": null,
     *    "file_path": null,
     *    "created_at": "2021-01-15 18:55 PM",
     *    "test_list": [
     *        {
     *            "id": 1,
     *            "prescription_id": 1,
     *            "lab_test_id": 1,
     *            "laboratory_id": null,
     *            "instructions": "Need report on this test",
     *            "test_status": "Dispensed outside.",
     *            "test_name": "Test 2",
     *            "test": {
     *                "id": 1,
     *                "name": "Test 2",
     *                "unique_id": "LAT0000001",
     *                "price": 300,
     *                "currency_code": "INR",
     *                "code": "ECO",
     *                "image": "http://localhost/fms-api-laravel/public/storage/uploads/labtest/1610715571tiger.jpg"
     *            }
     *        }
     *    ],
     *    "prescription": {
     *        "pdf_url": "http://localhost/fms-api-laravel/public/storage/uploads/prescription/1-1610717145.pdf",
     *        "prescription_unique_id": "PX0000001"
     *    },
     *    "appointment": {
     *        "id": 1,
     *        "doctor_id": 2,
     *        "patient_id": 3,
     *        "appointment_unique_id": "AP0000001",
     *        "date": "2021-01-18",
     *        "time": "15:00:00",
     *        "consultation_type": "ONLINE",
     *        "shift": "MORNING",
     *        "payment_status": null,
     *        "transaction_id": null,
     *        "total": null,
     *        "is_cancelled": 0,
     *        "is_completed": 1,
     *        "followup_id": null,
     *        "patient_info": {
     *            "id": "1",
     *            "case": "1",
     *            "email": "james@gmail.com",
     *            "mobile": "876543210",
     *            "last_name": "Bond",
     *            "first_name": "James",
     *            "middle_name": "007",
     *            "mobile_code": "+91",
     *            "patient_mobile": "987654321",
     *            "patient_mobile_code": "+91"
     *        },
     *        "laravel_through_key": 1,
     *        "booking_date": "2021-01-15",
     *        "doctor": {
     *            "id": 2,
     *            "first_name": "Theophilus",
     *            "middle_name": "Jos",
     *            "last_name": "Simeon",
     *            "email": "theophilus@logidots.com",
     *            "username": "theo",
     *            "country_code": "+91",
     *            "mobile_number": "8940330536",
     *            "user_type": "DOCTOR",
     *            "is_active": "1",
     *            "role": null,
     *            "currency_code": null,
     *            "approved_date": "2021-01-15",
     *            "profile_photo_url": null
     *        },
     *        "clinic_address": {
     *            "id": 1,
     *            "street_name": "South Road",
     *            "city_village": "Edamattom",
     *            "district": "Kottayam",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "686575",
     *            "country_code": null,
     *            "contact_number": null,
     *            "latitude": "10.53034500",
     *            "longitude": "76.21472900",
     *            "clinic_name": "romaguera"
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "Record not found."
     *}
     */
    public function getQuoteRequestLaboratoryById($id)
    {
        try {
            $record = QuoteRequest::with('prescription')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment.doctor')->with('prescription.appointment.clinic_address')->where('id', $id)->where('type', 'LAB')->firstOrFail();
            $record->makeHidden('medicine_list');
            $result = $record->toArray();
            unset($result['prescription']['info']);
            unset($result['prescription']['info']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['medicinelist']);
            $record['sample_collection'] = auth()->user()->laboratory->sample_collection;
            $record['order_amount'] = auth()->user()->laboratory->order_amount;

            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Record not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get Quotes Request
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array
     * @queryParam filter.search nullable string present
     * @queryParam filter.doctor nullable string present
     * @queryParam filter.status nullable boolean present 0 or 1
     * @queryParam dispense_request nullable number send 1
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 60,
     *            "unique_id": "QR0000060",
     *            "prescription_id": 89,
     *            "quote_reply": null,
     *            "status": "0",
     *            "submission_date": null,
     *            "file_path": null,
     *            "created_at": "2021-02-10 09:55:20 pm",
     *            "test_list": [
     *                {
     *                    "id": 1,
     *                    "prescription_id": 2,
     *                    "lab_test_id": 1,
     *                    "quote_generated": 0,
     *                    "instructions": null,
     *                    "test_status": "Dispensed at associated laboratory.",
     *                    "test_name": "Blood New",
     *                    "test": {
     *                        "id": 1,
     *                        "name": "Blood New",
     *                        "unique_id": "LAT0000001",
     *                        "price": 555,
     *                        "currency_code": "INR",
     *                        "code": "BL New Test.",
     *                        "image": null
     *                    }
     *                }
     *            ],
     *            "prescription": {
     *                "id": 89,
     *                "appointment_id": 248,
     *                "unique_id": "PX0000087",
     *                "created_at": "2021-02-10",
     *                "pdf_url": "http://localhost/fms-api-laravel/public/storage/uploads/prescription/89-1612974321.pdf",
     *                "status_medicine": "Yet to dispense.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "appointment": {
     *                    "id": 248,
     *                    "doctor_id": 2,
     *                    "patient_id": 47,
     *                    "appointment_unique_id": "AP0000248",
     *                    "date": "2021-02-11",
     *                    "time": "12:05:00",
     *                    "consultation_type": "ONLINE",
     *                    "shift": null,
     *                    "payment_status": null,
     *                    "transaction_id": null,
     *                    "total": null,
     *                    "is_cancelled": 0,
     *                    "is_completed": 1,
     *                    "followup_id": null,
     *                    "booking_date": "2021-02-10",
     *                    "current_patient_info": {
     *                        "user": {
     *                            "first_name": "Diana",
     *                            "middle_name": "Princess",
     *                            "last_name": "Wales",
     *                            "email": "diana@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "7878787878",
     *                            "profile_photo_url": null
     *                        },
     *                        "case": 1,
     *                        "info": {
     *                            "first_name": "Diana",
     *                            "middle_name": "Princess",
     *                            "last_name": "Wales",
     *                            "email": "diana@gmail.com",
     *                            "country_code": "+91",
     *                            "mobile_number": "7878787878",
     *                            "height": 156,
     *                            "weight": 55,
     *                            "gender": "FEMALE",
     *                            "age": 23
     *                        },
     *                        "address": {
     *                            "id": 132,
     *                            "street_name": "Vadakkaparampill",
     *                            "city_village": "PATHANAMTHITTA",
     *                            "district": "Pathanamthitta",
     *                            "state": "Kerala",
     *                            "country": "India",
     *                            "pincode": "689667",
     *                            "country_code": null,
     *                            "contact_number": "+917591985087",
     *                            "latitude": null,
     *                            "longitude": null,
     *                            "clinic_name": null
     *                        }
     *                    },
     *                    "doctor": {
     *                        "id": 2,
     *                        "first_name": "Theophilus",
     *                        "middle_name": "Jos",
     *                        "last_name": "Simeon",
     *                        "email": "theophilus@logidots.com",
     *                        "username": "theo",
     *                        "country_code": "+91",
     *                        "mobile_number": "8940330536",
     *                        "user_type": "DOCTOR",
     *                        "is_active": "1",
     *                        "role": null,
     *                        "currency_code": "INR",
     *                        "approved_date": "2021-01-04",
     *                        "profile_photo_url": null
     *                    },
     *                    "clinic_address": {
     *                        "id": 1,
     *                        "street_name": "South Road",
     *                        "city_village": "Edamatto",
     *                        "district": "Kottayam",
     *                        "state": "Kerala",
     *                        "country": "India",
     *                        "pincode": "686575",
     *                        "country_code": null,
     *                        "contact_number": "9786200983",
     *                        "latitude": "10.53034500",
     *                        "longitude": "76.21472900",
     *                        "clinic_name": "Neo clinic"
     *                    }
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote/request?page=1",
     *    "from": 1,
     *    "last_page": 11,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote/request?page=11",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/laboratory/quote/request?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/laboratory/quote/request",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 11
     *}
     *
     * @response 404 {
     *    "message": "Quotes request not found."
     *}
     */
    public function getQuoteRequestLaboratory(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.search' => 'nullable|present',
            'filter.doctor' => 'nullable|present',
            'filter.status' => 'nullable|present|in:0,1,Dispensed,Not Dispensed',
            'dispense_request' => 'nullable|in:1'
        ]);

        $list = QuoteRequest::with('prescription')->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->where('pharma_lab_id', auth()->user()->laboratory->id)->where('type', 'LAB');

        $status_column = 'status';
        if ($request->filled('dispense_request')) {
            $list = $list->where('quote_type', "1");
            $status_column = 'pharma_lab_status';
        } else {
            $list = $list->where('quote_type', '!=', "1");
        }

        $list = $list->where(function ($query) use ($validatedData, $status_column) {
            if (!is_null($validatedData['filter']['search'])) {

                if (strpos($validatedData['filter']['search'], 'QR') !== false) {
                    $query->where('unique_id', $validatedData['filter']['search']);
                }
            }
            if (!is_null($validatedData['filter']['status'])) {
                $query->where($status_column, $validatedData['filter']['status']);
            }
        });
        if (!is_null($validatedData['filter']['doctor'])) {
            $list = $list->whereHas('prescription.appointment.doctor', function ($query) use ($validatedData) {
                $query->orWhere('first_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
                $query->orWhere('middle_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
                $query->orWhere('last_name', 'like', '%' . $validatedData['filter']['doctor'] . '%');
            });
        }
        if (!is_null($validatedData['filter']['search']) && strpos($validatedData['filter']['search'], 'QR') === false) {
            $list = $list->whereHas(
                'prescription.appointment.clinic_address',
                function ($query) use ($validatedData) {

                    $query->where('clinic_name', 'like', '%' . $validatedData['filter']['search'] . '%');
                }
            );
        }
        $list = $list->with('prescription.appointment.doctor')->with('prescription.appointment.clinic_address')->orderBy('id', 'desc')->paginate(QuoteRequest::$page);

        if ($list->count() > 0) {
            $list->makeHidden('medicine_list');
            $result = $list->toArray();
            $datas = $result['data'];
            foreach ($datas as $key => $data) {
                unset($data['prescription']['info']);
                unset($data['prescription']['info']);
                unset($data['prescription']['appointment']['patient_details']);
                unset($data['prescription']['appointment']['patient_more_info']);
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            $result['sample_collection'] = auth()->user()->laboratory->sample_collection;
            $result['order_amount'] = auth()->user()->laboratory->order_amount;

            return response()->json($result, 200);
        }
        return new ErrorMessage('Quotes request not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory add Quote
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_request_id integer required
     * @bodyParam test_list array required
     * @bodyParam test_list.*.test_id integer required test id
     * @bodyParam test_list.*.price decimal required
     * @bodyParam test_list.*.instructions string required
     * @bodyParam total decimal required
     * @bodyParam discount decimal present nullable price
     * @bodyParam delivery_charge present nullable price
     * @bodyParam valid_till required date format-> Y-m-d
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "quote_request_id": [
     *            "The quote request id field is required."
     *        ],
     *        "total": [
     *            "The total field is required."
     *        ],
     *        "test_list.0.test_id": [
     *            "The test id field is required."
     *        ],
     *        "test_list.0.price": [
     *            "The price field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Quotes saved successfully."
     *}
     */
    public function addQuoteLaboratory(HttpQuoteRequest $request)
    {
        $data = $request->validated();
        unset($data['quote_request_id']);
        $quoteRequest = QuoteRequest::find($request->quote_request_id);
        $quote =  Quotes::updateOrCreate([
            'quote_request_id' => $request->quote_request_id,
            'pharma_lab_id' => auth()->user()->laboratory->id,
            'type' => 'LAB',
        ], [
            'quote_request_id' => $request->quote_request_id,
            'prescription_id' => $quoteRequest->prescription_id,
            'pharma_lab_id' => auth()->user()->laboratory->id,
            'type' => 'LAB',
            'quote_details' => $data,
            'status' => '0',
            'valid_till' => $data['valid_till'],
        ]);
        if ($quote->wasRecentlyCreated) {
            $quote->unique_id = getQuoteId();
            $quote->save();
        }

        $quoteRequest->status = '1';
        $quoteRequest->save();
        return new SuccessMessage('Quotes saved successfully.', 200);
    }

    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy add Quote
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_request_id integer required
     * @bodyParam medicine_list array required
     * @bodyParam medicine_list.*.medicine_id integer required medicine id
     * @bodyParam medicine_list.*.price decimal required price
     * @bodyParam medicine_list.*.unit number required
     * @bodyParam medicine_list.*.dosage string required
     * @bodyParam medicine_list.*.duration string required
     * @bodyParam medicine_list.*.instructions string required
     * @bodyParam total decimal required price
     * @bodyParam discount decimal present nullable price
     * @bodyParam delivery_charge present nullable price
     * @bodyParam valid_till required date format-> Y-m-d
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "quote_request_id": [
     *            "The quote request id field is required."
     *        ],
     *        "total": [
     *            "The total field is required."
     *        ],
     *        "medicine_list.0.medicine_id": [
     *            "The medicine id field is required."
     *        ],
     *        "medicine_list.0.price": [
     *            "The price field is required."
     *        ],
     *        "medicine_list.0.unit": [
     *            "The unit must be a number."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Quotes saved successfully."
     *}
     */
    public function addQuotePharmacy(HttpQuoteRequest $request)
    {
        $data = $request->validated();
        unset($data['quote_request_id']);
        $quoteRequest = QuoteRequest::find($request->quote_request_id);
        $quote = Quotes::updateOrCreate([
            'quote_request_id' => $request->quote_request_id,
            'pharma_lab_id' => auth()->user()->pharmacy->id,
            'type' => 'MED',
        ], [
            'quote_request_id' => $request->quote_request_id,
            'prescription_id' => $quoteRequest->prescription_id,
            'pharma_lab_id' => auth()->user()->pharmacy->id,
            'type' => 'MED',
            'quote_details' => $data,
            'status' => '0',
            'valid_till' => $data['valid_till'],
        ]);
        if ($quote->wasRecentlyCreated) {
            $quote->unique_id = getQuoteId();
            $quote->save();
        }
        $quoteRequest->status = '1';
        $quoteRequest->save();
        return new SuccessMessage('Quotes saved successfully.', 200);
    }
    /**
     * @authenticated
     *
     * @group Pharmacy
     *
     * Pharmacy get Quotes by QuoteRequest Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam quote_request_id required id of Quote request list
     *
     * @response 200 {
     *    "id": 6,
     *    "quote_request_id": 65,
     *    "status": "0",
     *    "medicine": {
     *        "total": 188.3,
     *        "discount": "1",
     *        "delivery_charge": "1",
     *        "medicine_list": [
     *            {
     *                "unit": 1,
     *                "price": 10,
     *                "dosage": "1 - 0 - 1 - 0",
     *                "duration": "4 days",
     *                "medicine_id": 2,
     *                "instructions": null,
     *                "no_of_refill": "1",
     *                "medicine": {
     *                    "id": 2,
     *                    "category_id": 1,
     *                    "sku": "MED0000002",
     *                    "composition": "water",
     *                    "weight": 12,
     *                    "weight_unit": "g",
     *                    "name": "test",
     *                    "manufacturer": "dndnd",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Generic",
     *                    "qty_per_strip": 3,
     *                    "price_per_strip": 10,
     *                    "rate_per_unit": 12,
     *                    "rx_required": 0,
     *                    "short_desc": "good",
     *                    "long_desc": "null",
     *                    "cart_desc": "cart good",
     *                    "image_name": "medicine.png",
     *                    "image_url": null
     *                }
     *            },
     *            {
     *                "unit": 1,
     *                "price": 100.3,
     *                "dosage": "1 - 0 - 1 - 0",
     *                "duration": "2 days",
     *                "medicine_id": 4,
     *                "instructions": null,
     *                "no_of_refill": "1",
     *                "medicine": {
     *                    "id": 4,
     *                    "category_id": 2,
     *                    "sku": "MED0000004",
     *                    "composition": "test data compo",
     *                    "weight": 170.56,
     *                    "weight_unit": "mg",
     *                    "name": "Paraceta Test",
     *                    "manufacturer": "Pfizer",
     *                    "medicine_type": "Suppositories",
     *                    "drug_type": "Branded",
     *                    "qty_per_strip": 5,
     *                    "price_per_strip": 100.3,
     *                    "rate_per_unit": 6,
     *                    "rx_required": 1,
     *                    "short_desc": null,
     *                    "long_desc": "null",
     *                    "cart_desc": null,
     *                    "image_name": null,
     *                    "image_url": null
     *                }
     *            }
     *        ]
     *    },
     *    "prescription": {
     *        "id": 76,
     *        "appointment_id": 234,
     *        "unique_id": "PX0000076",
     *        "created_at": "2021-02-10",
     *        "pdf_url": null,
     *        "status_medicine": "Yet to dispense.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *        "appointment": {
     *            "id": 234,
     *            "doctor_id": 2,
     *            "patient_id": 47,
     *            "appointment_unique_id": "AP0000234",
     *            "date": "2021-02-10",
     *            "time": "10:00:00",
     *            "consultation_type": "INCLINIC",
     *            "shift": null,
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-02-10",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Diana",
     *                    "middle_name": "Princess",
     *                    "last_name": "Wales",
     *                    "email": "diana@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "7878787878",
     *                    "profile_photo_url": null
     *                },
     *                "case": 1,
     *                "info": {
     *                    "first_name": "Diana",
     *                    "middle_name": "Princess",
     *                    "last_name": "Wales",
     *                    "email": "diana@gmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "7878787878",
     *                    "height": 156,
     *                    "weight": 55,
     *                    "gender": "FEMALE",
     *                    "age": 23
     *                },
     *                "address": {
     *                    "id": 132,
     *                    "street_name": "Vadakkaparampill",
     *                    "city_village": "PATHANAMTHITTA",
     *                    "district": "Pathanamthitta",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "689667",
     *                    "country_code": null,
     *                    "contact_number": "+917591985087",
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": "INR",
     *                "approved_date": "2021-01-04",
     *                "profile_photo_url": null
     *            }
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "No record found."
     *}
     */
    public function getPharmacyAddedQuoteByRequestId($id)
    {
        try {
            $record = Quotes::where('quote_request_id', $id)->where('pharma_lab_id', auth()->user()->pharmacy->id)->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment')->with('prescription.appointment.doctor')->firstOrFail();
            $record->makeHidden('test');
            $result = $record->toArray();

            unset($result['quote_from']);
            unset($result['pharmacy']);
            unset($result['prescription']['info']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['medicinelist']);
            unset($result['prescription']['testlist']);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('No record found.');
        }
    }
    /**
     * @authenticated
     *
     * @group Laboratory
     *
     * Laboratory get Quotes by QuoteRequest Id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam quote_request_id required id of Quote request list
     *
     * @response 200 {
     *    "id": 2,
     *    "quote_request_id": 2,
     *    "status": "0",
     *    "test": {
     *        "total": "055",
     *        "discount": "1",
     *        "delivery_charge": "1",
     *        "test_list": [
     *            {
     *                "price": "55",
     *                "test_id": 1,
     *                "test": {
     *                    "id": 1,
     *                    "name": "Blood New",
     *                    "unique_id": "LAT0000001",
     *                    "price": 555,
     *                    "currency_code": "INR",
     *                    "code": "BL New Test.",
     *                    "image": null
     *                }
     *            }
     *        ]
     *    },
     *    "prescription": {
     *        "id": 14,
     *        "appointment_id": 26,
     *        "unique_id": "PX0000014",
     *        "created_at": "2021-01-12",
     *        "pdf_url": null,
     *        "patient": {
     *            "id": 22,
     *            "first_name": "Vishnu",
     *            "middle_name": "S",
     *            "last_name": "Sharma",
     *            "email": "vishnusharmatest123@yopmail.com",
     *            "country_code": "+91",
     *            "mobile_number": "3736556464",
     *            "profile_photo_url": null
     *        },
     *        "status_medicine": "Dispensed.",
     *                "patient": {
     *                    "id": 22,
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *        "appointment": {
     *            "id": 26,
     *            "doctor_id": 2,
     *            "patient_id": 3,
     *            "appointment_unique_id": "AP0000026",
     *            "date": "2021-01-14",
     *            "time": "12:05:00",
     *            "consultation_type": "ONLINE",
     *            "shift": "AFTERNOON",
     *            "payment_status": null,
     *            "transaction_id": null,
     *            "total": null,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "booking_date": "2021-01-12",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "profile_photo_url": null
     *                },
     *                "case": "1",
     *                "info": {
     *                    "first_name": "Test",
     *                    "middle_name": null,
     *                    "last_name": "Patient",
     *                    "email": "patient@logidots.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "9876543210",
     *                    "height": 1,
     *                    "weight": 0,
     *                    "gender": "MALE",
     *                    "age": 20
     *                },
     *                "address": {
     *                    "id": 36,
     *                    "street_name": "Sreekariyam",
     *                    "city_village": "Trivandrum",
     *                    "district": "Alappuzha",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "688001",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "doctor": {
     *                "id": 2,
     *                "first_name": "Theophilus",
     *                "middle_name": "Jos",
     *                "last_name": "Simeon",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": null,
     *                "currency_code": "INR",
     *                "approved_date": "2021-01-04",
     *                "profile_photo_url": null
     *            }
     *        }
     *    }
     *}
     *
     * @response 404 {
     *    "message": "No record found."
     *}
     */
    public function getLaboratoryAddedQuoteByRequestId($id)
    {
        try {
            $record = Quotes::where('quote_request_id', $id)->where('pharma_lab_id', auth()->user()->laboratory->id)->with('prescription.patient:id,first_name,middle_name,last_name,email,country_code,mobile_number')->with('prescription.appointment')->with('prescription.appointment.doctor')->firstOrFail();
            $record->makeHidden('medicine');
            $result = $record->toArray();
            unset($result['prescription']['info']);
            unset($result['prescription']['info']);
            unset($result['prescription']['appointment']['patient_details']);
            unset($result['prescription']['appointment']['patient_more_info']);
            unset($result['prescription']['medicinelist']);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return new ErrorMessage('No record found.');
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get Quotes
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam type required string send MED for phamarcy quote list, LAB for laboratory quote list
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 41,
     *            "status": "0",
     *            "created_at": "2021-02-23 08:30:39 pm",
     *            "unique_id": "QOOOOOO1",
     *            "quote_from": {
     *                "id": 1,
     *                "name": "Pharmacy Name",
     *                "address": [
     *                    {
     *                        "id": 4,
     *                        "street_name": "East Road",
     *                        "city_village": "Edamon",
     *                        "district": "Kollam",
     *                        "state": "Kerala",
     *                        "country": "India",
     *                        "pincode": "691307",
     *                        "country_code": null,
     *                        "contact_number": null,
     *                        "land_mark": null,
     *                        "latitude": "10.53034500",
     *                        "longitude": "76.21472900",
     *                        "clinic_name": null
     *                    }
     *                ]
     *            },
     *            "quote_request": {
     *                "id": 1,
     *                "created_at": "2021-01-12 12:54:30 am",
     *                "type": "MED",
     *                "quote_type": null
     *            },
     *            "grant_total": 161.67
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/quote?page=1",
     *    "from": 1,
     *    "last_page": 6,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/quote?page=6",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/quote?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/quote",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 6
     *}
     *
     * @response 404 {
     *    "message": "Quotes not found."
     *}
     */
    public function getPatientQuoteList(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:MED,LAB',
        ]);


        $list = Quotes::whereHas('prescription', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->where('type', $data['type'])->doesntHave('order')->with('quote_request:id,created_at,quote_type,quote_details')->orderBy('id', 'desc')->paginate(Quotes::$page);

        if ($list->count() > 0) {
            //$list->makeHidden('test');
            $list->makeHidden('pharmacy');
            $list->makeHidden('laboratory');
            $result = $list->toArray();
            $datas = $result['data'];
            $tax_percent = $commission = 0;
            if ($data['type'] == 'LAB') {
                $list = TaxService::where('name', 'Lab test Lab')->first();
                if ($list) {
                    $tax_percent = $list->tax_percent;
                    $commission = $list->commission;
                }
            } else {
                $list = TaxService::where('name', 'Medicine purchase Indirect')->first();
                if ($list) {
                    $tax_percent = $list->tax_percent;
                    $commission = $list->commission;
                }
            }
            dd($datas);
            foreach ($datas as $key => $data) {

                $list_total = $delivery_charge = $discount = $sub_total = 0;

                if ($data['type'] == 'LAB') {
                    $list_total = $sub_total = $data['test']['total'];
                    $delivery_charge = $data['test']['delivery_charge'];
                    $discount = $data['test']['discount'];
                    $list_total = ($list_total - $delivery_charge) + $discount;
                } else {
                    $list_total = $sub_total = $data['medicine']['total'];
                    $delivery_charge = $data['medicine']['delivery_charge'];
                    $discount = $data['medicine']['discount'];
                    $list_total = ($list_total - $delivery_charge) + $discount;
                }
                $total_commission = ($list_total * $commission) / 100;
                $total_tax = ($total_commission * $tax_percent) / 100;
                $total_fees = round(($sub_total + $total_tax), 2);
                $data['grant_total'] = $total_fees;

                unset($data['medicine']['medicine_list']);
                unset($data['test']['test_list']);
                unset($data['quote_request']['medicine_list']);
                unset($data['quote_request']['test_list']);
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);

                $data['appointment_unique_id'] = NULL;
                $data['appointment_date'] = NULL;
                $appointment = \DB::table('appointments')
                    ->leftJoin('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                    ->leftJoin('quotes', 'quotes.prescription_id', '=', 'prescriptions.id')->where('quotes.id', $data['id'])->select('appointments.appointment_unique_id', 'appointments.date')
                    ->get();

                if ($appointment->isNotEmpty()) {
                    $data['appointment_unique_id'] = $appointment->first()->appointment_unique_id;
                    $data['appointment_date'] = $appointment->first()->date;
                }
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            return response()->json($result, 200);
        }
        return new ErrorMessage('Quotes not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient delete quote by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of quote
     *
     * @response 200 {
     *    "message": "Quote deleted successfully."
     *}
     *@response 404 {
     *    "message": "Quote not found."
     *}
     * @response 401 {
     *    "message": "Unauthenticated."
     *}
     */
    public function deleteQuote($id)
    {
        try {
            Quotes::whereHas('prescription.appointment', function ($query) {
                $query->where('patient_id', auth()->user()->id);
            })->findOrFail($id)->destroy($id);
            return new SuccessMessage('Quote deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Quote not found.', 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient get quote by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of quote
     *
     * @response 200 {
     *    "id": 75,
     *    "created_at": "2021-03-02 09:12:58 pm",
     *    "unique_id": "QT0000076",
     *    "medicine": {
     *        "total": 200,
     *        "discount": "80",
     *        "delivery_charge": "40",
     *        "medicine_list": [
     *            {
     *                "unit": "3",
     *                "price": 60,
     *                "dosage": "1 - 0 - 0 - 0",
     *                "duration": "2 days",
     *                "medicine_id": 8,
     *                "instructions": "James Bond New outside",
     *                "no_of_refill": "0",
     *                "medicine": {
     *                    "id": 8,
     *                    "category_id": 3,
     *                    "sku": "MED0000008",
     *                    "composition": "Syrup",
     *                    "weight": 250,
     *                    "weight_unit": "mcg",
     *                    "name": "Febrex 125",
     *                    "manufacturer": "Pentamark Organics",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Branded",
     *                    "qty_per_strip": 6,
     *                    "price_per_strip": 60,
     *                    "rate_per_unit": 10,
     *                    "rx_required": 1,
     *                    "short_desc": "Febrex 125 is used to temporarily relieve fever and mild to moderate pain such as muscle ache, headache, toothache, and backache.",
     *                    "long_desc": null,
     *                    "cart_desc": "Febrex 125",
     *                    "image_name": "febrex.jpg",
     *                    "image_url": null
     *                }
     *            },
     *            {
     *                "unit": "2",
     *                "price": 30,
     *                "dosage": "1 - 0 - 0 - 0",
     *                "duration": "2 days",
     *                "medicine_id": 7,
     *                "instructions": "James Bond New outside",
     *                "no_of_refill": "0",
     *                "medicine": {
     *                    "id": 7,
     *                    "category_id": 1,
     *                    "sku": "MED0000007",
     *                    "composition": "Paracetamol",
     *                    "weight": 5,
     *                    "weight_unit": "g",
     *                    "name": "Pyremol 650",
     *                    "manufacturer": "Alembic Ltd",
     *                    "medicine_type": "Capsules",
     *                    "drug_type": "Branded",
     *                    "qty_per_strip": 10,
     *                    "price_per_strip": 30,
     *                    "rate_per_unit": 3,
     *                    "rx_required": 0,
     *                    "short_desc": "This medicine should be used with caution in patients with liver diseases due to the increased risk of severe adverse effects.",
     *                    "long_desc": null,
     *                    "cart_desc": "The pain relieving effect of this medicine can be observed within an hour of administration. For fever reduction, the time taken to show the effect is about 30 minutes.",
     *                    "image_name": "pyremol.jpg",
     *                    "image_url": null
     *                }
     *            }
     *        ]
     *    },
     *    "test": [],
     *    "quote_from": {
     *        "id": 1,
     *        "name": "Pharmacy Name",
     *        "address": [
     *            {
     *                "id": 4,
     *                "street_name": "50/23",
     *                "city_village": "Tirunelveli",
     *                "district": "Tirunelveli",
     *                "state": "Tamil Nadu",
     *                "country": "India",
     *                "pincode": "627354",
     *                "country_code": null,
     *                "contact_number": null,
     *                "land_mark": null,
     *                "latitude": "8.55160940",
     *                "longitude": "77.76987023",
     *                "clinic_name": null
     *            }
     *        ]
     *    },
     *    "order": {
     *        "id": 1,
     *        "user_id": 3,
     *        "tax": 10,
     *        "subtotal": 20,
     *        "discount": 2,
     *        "delivery_charge": 2,
     *        "total": 500.49,
     *        "shipping_address_id": 1,
     *        "payment_status": "Not Paid",
     *        "delivery_status": "Open",
     *        "delivery_info": null
     *    },
     *    "quote_request": {
     *        "id": 125,
     *        "created_at": "2021-02-12 12:01:26 am",
     *        "quote_type": null,
     *        "type": "MED"
     *    },
     *     "grant_total": 161.67,
     *    "tax_percent": 0,
     *    "commission": 0
     *}
     * @response 404 {
     *    "message": "Quote not found."
     *}
     */
    public function getPatientQuoteById($id)
    {
        try {
            $record = Quotes::with('order')->whereHas('prescription', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->with('quote_request:id,created_at,quote_type,type,quote_details')->with('pharmacy.address')->findOrFail($id);
            $record->makeHidden('pharmacy');
            $record->makeHidden('laboratory');
            $record = $record->toArray();

            unset($record['quote_request']['medicine_list']);
            unset($record['quote_request']['test_list']);
            unset($record['quote_request']['prescription']);

            $tax_percent = $commission = $sub_total = $list_total = $delivery_charge = $discount = 0;
            if ($record['quote_request']['type'] == 'LAB') {
                $list = TaxService::where('name', 'Lab test Lab')->first();
                if ($list) {
                    $tax_percent = $list->tax_percent;
                    $commission = $list->commission;
                }
                $list_total = $sub_total = $record['test']['total'];
                $delivery_charge = $record['test']['delivery_charge'];
                $discount = $record['test']['discount'];
                $list_total = ($list_total - $delivery_charge) + $discount;
            } else {
                $list = TaxService::where('name', 'Medicine purchase Indirect')->first();
                if ($list) {
                    $tax_percent = $list->tax_percent;
                    $commission = $list->commission;
                }
                $list_total = $sub_total = $record['medicine']['total'];
                $delivery_charge = $record['medicine']['delivery_charge'];
                $discount = $record['medicine']['discount'];
                $list_total = ($list_total - $delivery_charge) + $discount;
            }

            $total_commission = ($list_total * $commission) / 100;
            $total_tax = ($total_commission * $tax_percent) / 100;
            $total_fees = round(($sub_total + $total_tax), 2);

            $record['tax_percent'] = $tax_percent;
            $record['commission'] = $commission;
            $record['grant_total'] = $total_fees;
            return response()->json($record, 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Quote not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group General
     *
     * Pharmacy, Laboratory edit dispense request
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_request_id integer required id of quote request
     * @bodyParam bill_number string present
     * @bodyParam bill_amount numeric present
     * @bodyParam bill_date date present format -> Y-m-d
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "quote_request_id": [
     *            "The quote request id field is required."
     *        ],
     *        "bill_number": [
     *            "The bill number field must be present."
     *        ],
     *        "bill_amount": [
     *            "The bill amount must be a number."
     *        ],
     *        "bill_date": [
     *            "The bill date does not match the format Y-m-d."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Record updated successfully."
     *}
     */

    public function updateDespenseRequest(Request $request)
    {
        if (auth()->user()->usertype == 'PHARMACIST') {
            $type = 'MED';
            $pharma_lab_id = auth()->user()->pharmacy->id;
        } else {
            $type = 'LAB';
            $pharma_lab_id = auth()->user()->laboratory->id;
        }
        $request->validate([
            'quote_request_id' => 'required|exists:quote_requests,id,deleted_at,NULL,type,' . $type . ',status,1,pharma_lab_id,' . $pharma_lab_id,
            'bill_number' => 'present|nullable',
            'bill_amount' => 'present|nullable|numeric',
            'bill_date' => 'present|nullable|date_format:Y-m-d',
        ]);

        $record = QuoteRequest::find($request->quote_request_id);
        $record->bill_number = $request->bill_number;
        $record->bill_amount = $request->bill_amount;
        $record->bill_date = $request->bill_date;
        $record->save();
        return new SuccessMessage('Record updated successfully.');
    }
}
