<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\PaymentService;
use App\Jobs\SendEmailJob;
use App\Model\Appointments;
use App\Model\LaboratoryInfo;
use App\Model\OrderItems;
use App\Model\Orders;
use App\Model\Payments;
use App\Model\Pharmacy;
use App\Model\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Str;

class OrderController extends Controller
{
    public $key_id, $key_secret;

    public function __construct()
    {
        $this->key_id = config('app.razor_pay')['key_id'];
        $this->key_secret = config('app.razor_pay')['key_secret'];
    }

    /**
     * @authenticated
     *
     * @group Orders
     *
     * User place order
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam quote_id integer required
     * @bodyParam tax double required
     * @bodyParam subtotal double required
     * @bodyParam discount double required
     * @bodyParam delivery_charge double required
     * @bodyParam total double required
     * @bodyParam commission double required
     * @bodyParam shipping_address_id integer required id of selected address
     * @bodyParam pharma_lab_id integer required pharmacy or laboratory id from  quote_from object
     * @bodyParam type integer required MED,LAB -> returned from  quote_from object
     * @bodyParam order_items array required
     * @bodyParam order_items.*.item_id integer required
     * @bodyParam order_items.*.price double required
     * @bodyParam order_items.*.quantity integer required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "tax": [
     *            "The tax field is required."
     *        ],
     *        "subtotal": [
     *            "The subtotal field is required."
     *        ],
     *        "discount": [
     *            "The discount field is required."
     *        ],
     *        "delivery_charge": [
     *            "The delievery charge field is required."
     *        ],
     *        "total": [
     *            "The total field is required."
     *        ],
     *        "shipping_address_id": [
     *            "The shipping address id field is required."
     *        ],
     *        "pharma_lab_id": [
     *            "The pharma lab id field is required."
     *        ],
     *        "type": [
     *            "The type field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "razorpay_order_id": "order_GhKYoQJVtCf928",
     *    "currency": "INR",
     *    "order_id": 2,
     *    "total": "140",
     *    "name": "James Anderson",
     *    "email": "james.andersontest66@yopmail.com"
     *}
     */
    public function checkOutOrder(OrderRequest $request)
    {

        $data = $request->validated();

        if ($data['type'] == 'MED') {
            $receipiant = Pharmacy::withTrashed()->where('user_id', $data['pharma_lab_id'])->first();
        } else {
            $receipiant = LaboratoryInfo::withTrashed()->where('user_id', $data['pharma_lab_id'])->first();
        }
        $receipiant_id = $receipiant->user_id;
        try {
            $api = new Api($this->key_id, $this->key_secret);
            $razorpay_order = $api->order->create(
                array(
                    'receipt' => auth()->user()->email,
                    'amount' => $data['total'] * 100,
                    'currency' => 'INR',
                    'notes' => ['Order payment']
                )
            );

            $razorpay_order_id = $razorpay_order->id;
            $order = Orders::create([
                'unique_id' => getOrderId(),
                'user_id' => auth()->user()->id,
                'quote_id' => $data['quote_id'],
                'tax' => $data['tax'],
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'total' => $data['total'],
                'commission' => $data['commission'],
                'delivery_charge' => $data['delivery_charge'],
                'shipping_address_id' => $data['shipping_address_id'],
                'pharma_lab_id' => $data['pharma_lab_id'],
                'type' => $data['type'],
                'need_delivery' => $data['need_delivery'],
            ]);

            Payments::create([
                'unique_id' => getPaymentId(),
                'user_id' => auth()->user()->id,
                'recepient_id' => $receipiant_id,
                'type_id' => $order->id,
                'type' => 'ORDER',
                'total_amount' => $data['total'],
                'razorpay_order_id' => $razorpay_order_id,
            ]);

            foreach ($data['order_items'] as $key => $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'item_id' => $item['item_id'],
                    'type' => $order->type,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }
            return response()->json(['razorpay_order_id' => $razorpay_order_id, 'currency' => 'INR', 'order_id' => $order->id, 'total' => $order->total, 'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email], 200);
        } catch (\Exception $e) {
            return new ErrorMessage($e->getMessage(), 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Orders
     *
     * User confirm payment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam razorpay_payment_id string required
     * @bodyParam razorpay_order_id string required
     * @bodyParam razorpay_signature string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "razorpay_payment_id": [
     *            "The razorpay payment id field is required."
     *        ],
     *        "razorpay_order_id": [
     *            "The razorpay order id field is required."
     *        ],
     *        "razorpay_signature": [
     *            "The razorpay signature field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Payment successfull."
     *}
     * @response 422 {
     *    "message": "Invalid signature passed."
     *}
     * @response 422 {
     *    "message": "OrderId not found."
     *}
     */
    public function confirmPayment(OrderRequest $request)
    {
        $data = $request->validated();
        try {
            $record = Payments::where('razorpay_order_id', $data['razorpay_order_id'])->with('orders')->firstOrFail();

            try {
                $service = 'In direct';
                $quote_requests = \DB::table('quote_requests')
                    ->leftJoin('quotes', 'quotes.quote_request_id', '=', 'quote_requests.id')
                    ->where('quotes.id', '=', $record->orders->quote_id)
                    ->select('quote_requests.quote_type')
                    ->first();

                if ($quote_requests) {

                    if ($quote_requests->quote_type == 0) {
                        $service = 'Direct';
                    }
                }

                $api = new Api($this->key_id, $this->key_secret);
                $attributes  = array(
                    'razorpay_signature'  => $data['razorpay_signature'],
                    'razorpay_payment_id'  => $data['razorpay_payment_id'],
                    'razorpay_order_id' => $data['razorpay_order_id']
                );
                $api->utility->verifyPaymentSignature($attributes);
                $record->payment_status = 'Paid';
                $record->razorpay_signature = $data['razorpay_signature'];
                $record->razorpay_payment_id = $data['razorpay_payment_id'];
                $record->save();

                $record->orders()->update([
                    'payment_status'  => 'Paid',
                ]);

                $earnings = $record->orders->commission + $record->orders->tax;
                $payable_to_vendor = $record->total_amount - $earnings;

                Sales::create([
                    'payout_id' => getSalesId(),
                    'payment_id' => $record->id,
                    'service' => $service,
                    'type' => $record->orders->type,
                    'type_id' =>  $record->recepient_id,
                    'user_id' => $record->user_id,
                    'total' => $record->total_amount,
                    'tax_amount' => $record->orders->tax,
                    'earnings' => $earnings,
                    'payable_to_vendor' => $payable_to_vendor,
                ]);
                return new SuccessMessage('Payment successfull.');
            } catch (\Exception $exception) {
                Log::debug('ORDERCONTROLLER', ['confirmPayment' => $exception->getMessage()]);

                return new ErrorMessage('Invalid signature passed.', 422);
            }
        } catch (\Exception $exception) {
            Log::debug('ORDERCONTROLLER', ['confirmPayment catch 2' => $exception->getMessage()]);

            return new ErrorMessage('OrderId not found.', 422);
        }
    }

    /**
     * @group Appointments
     *
     * Create checkout
     *
     * @authenticated
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id integer required
     * @bodyParam tax price required
     * @bodyParam total price required
     * @bodyParam commission price required

     * @response 200 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ],
     *        "tax": [
     *            "The tax field is required."
     *        ],
     *        "total": [
     *            "The total field is required."
     *        ],
     *        "minutes": [
     *            "The minutes field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "razorpay_order_id": "order_Ghk58p1UZD35g8",
     *    "currency": "INR",
     *    "appointment_id": 1,
     *    "total": "5000",
     *    "name": "Ben Patient",
     *    "email": "patient@logidots.com"
     *}
     */
    public function appointmentCheckOut(OrderRequest $request)
    {
        $data = $request->validated();
        $appointment = Appointments::find($data['appointment_id']);
        try {
            $api = new Api($this->key_id, $this->key_secret);
            $razorpay_order = $api->order->create(
                array(
                    'receipt' => auth()->user()->email,
                    'amount' => $data['total'] * 100,
                    'currency' => 'INR',
                    'notes' => ['Appointment payment']
                )
            );

            $razorpay_order_id = $razorpay_order->id;
            $appointment->tax = $data['tax'];
            $appointment->total = $data['total'];
            $appointment->commission = $data['commission'];
            $appointment->save();

            Payments::create([
                'unique_id' => getPaymentId(),
                'user_id' => $appointment->patient_id,
                'recepient_id' => $appointment->doctor_id,
                'type_id' => $appointment->id,
                'type' => 'APPOINTMENT',
                'total_amount' => $data['total'],
                'razorpay_order_id' => $razorpay_order_id,
            ]);

            return response()->json(['razorpay_order_id' => $razorpay_order_id, 'currency' => 'INR', 'appointment_id' => $appointment->id, 'total' => $appointment->total, 'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name, 'email' => auth()->user()->email], 200);
        } catch (\Exception $e) {
            return new ErrorMessage($e->getMessage(), 422);
        }
    }
    /**
     * @authenticated
     *
     * @group Appointments
     *
     * Confirm payment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam razorpay_payment_id string required
     * @bodyParam razorpay_order_id string required
     * @bodyParam razorpay_signature string required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "razorpay_payment_id": [
     *            "The razorpay payment id field is required."
     *        ],
     *        "razorpay_order_id": [
     *            "The razorpay order id field is required."
     *        ],
     *        "razorpay_signature": [
     *            "The razorpay signature field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Payment successfull."
     *}
     * @response 422 {
     *    "message": "Invalid signature passed."
     *}
     * @response 422 {
     *    "message": "OrderId not found."
     *}
     */
    public function appointmentConfirmPayment(OrderRequest $request)
    {
        $data = $request->validated();
        try {
            $record = Payments::where('razorpay_order_id', $data['razorpay_order_id'])->with('appointments')->firstOrFail();

            try {
                $api = new Api($this->key_id, $this->key_secret);
                $attributes  = array(
                    'razorpay_signature'  => $data['razorpay_signature'],
                    'razorpay_payment_id'  => $data['razorpay_payment_id'],
                    'razorpay_order_id' => $data['razorpay_order_id']
                );
                $api->utility->verifyPaymentSignature($attributes);
                $record->payment_status = 'Paid';
                $record->razorpay_signature = $data['razorpay_signature'];
                $record->razorpay_payment_id = $data['razorpay_payment_id'];
                $record->save();

                $record->appointments()->update([
                    'payment_status'  => 'Paid',
                ]);
                $earnings = $record->appointments->commission + $record->appointments->tax;
                $payable_to_vendor = $record->total_amount - $earnings;

                Sales::create([
                    'payout_id' => getSalesId(),
                    'service' => 'Direct',
                    'payment_id' => $record->id,
                    'type' => 'DOC',
                    'type_id' =>  $record->recepient_id,
                    'user_id' => $record->user_id,
                    'total' => $record->total_amount,
                    'tax_amount' => $record->appointments->tax,
                    'earnings' => $earnings,
                    'payable_to_vendor' => $payable_to_vendor,
                ]);
                return new SuccessMessage('Payment successfull.');
            } catch (\Exception $exception) {
                Log::debug('ORDERCONTROLLER', ['appointmentConfirmPayment' => $exception->getMessage()]);
                return new ErrorMessage('Invalid signature passed.', 422);
            }
        } catch (\Exception $exception) {
            Log::debug('ORDERCONTROLLER', ['appointmentConfirmPayment catch 2' => $exception->getMessage()]);
            return new ErrorMessage('OrderId not found.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Appointments
     *
     * Cancel payment
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam appointment_id integer required
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "appointment_id": [
     *            "The appointment id field is required."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "message": "Payment cancelled successfully."
     *}
     * @response 404 {
     *    "message": "Appointment can't be cancelled."
     *}
     */
    public function appointmentCancelPayment(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);
        // check if appointment is valid
        try {
            $appointment = Appointments::where('patient_id', auth()->user()->id)->where('is_completed', 0)->where('is_cancelled', 0)->where('payment_status', 'Not Paid')->findOrFail($data['appointment_id']);
            $appointment->delete();
            return new SuccessMessage('Payment cancelled successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Appointment can\'t be cancelled.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Orders
     *
     * Get order list Patient, Pharmacy, Laboratory
     *
     * @queryParam type required string MED for orders from pharmacy , LAB for orders from laboratory. SEND THIS PARAM ONLY FOR REQUEST FROM PATIENT LOGIN.
     * @queryParam delivery_status nullable string values -> Pending,In-Progress,Completed SEND THIS PARAM ONLY FOR REQUEST FROM PATIENT LOGIN.
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 6,
     *            "unique_id": null,
     *            "user_id": 3,
     *            "tax": 10,
     *            "subtotal": 20,
     *            "discount": 2,
     *            "delivery_charge": 2,
     *            "total": 500.49,
     *            "shipping_address_id": 1,
     *            "payment_status": "Paid",
     *            "delivery_status": "Pending",
     *            "delivery_info": null,
     *            "created_at": "2021-03-04 10:25:40 am",
     *            "quote": {
     *                "quote_from": {
     *                    "id": 1,
     *                    "name": "Pharmacy Name",
     *                    "address": [
     *                        {
     *                            "id": 4,
     *                            "street_name": "50/23",
     *                            "city_village": "Tirunelveli",
     *                            "district": "Tirunelveli",
     *                            "state": "Tamil Nadu",
     *                            "country": "India",
     *                            "pincode": "627354",
     *                            "country_code": null,
     *                            "contact_number": null,
     *                            "land_mark": null,
     *                            "latitude": "8.55160940",
     *                            "longitude": "77.76987023",
     *                            "clinic_name": null
     *                        }
     *                    ]
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=1",
     *    "from": 1,
     *    "last_page": 6,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=6",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/orders",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 6
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 9,
     *            "unique_id": null,
     *            "user_id": 3,
     *            "tax": 10,
     *            "subtotal": 20,
     *            "discount": 2,
     *            "delivery_charge": 2,
     *            "total": 500.49,
     *            "shipping_address_id": 1,
     *            "payment_status": "Not Paid",
     *            "delivery_status": "Pending",
     *            "delivery_info": null,
     *            "created_at": "2021-03-08 03:16:16 pm",
     *            "quote": {
     *                "quote_from": {
     *                    "id": 11,
     *                    "name": "Lifeline Labs Pvt ltd",
     *                    "address": [
     *                        {
     *                            "id": 164,
     *                            "street_name": "Near sunshine Apartments",
     *                            "city_village": "Telengana",
     *                            "district": "Hyderabad",
     *                            "state": "Telangana",
     *                            "country": "India",
     *                            "pincode": "500001",
     *                            "country_code": null,
     *                            "contact_number": null,
     *                            "land_mark": null,
     *                            "latitude": "17.38743640",
     *                            "longitude": "78.47217290",
     *                            "clinic_name": null
     *                        }
     *                    ]
     *                }
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/orders?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/orders",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "type": [
     *            "The type field is required."
     *        ]
     *    }
     *}
     * @response 404 {
     *    "message": "Orders not found."
     *}
     */
    public function getOrderList(Request $request)
    {
        $list = Orders::orderBy('id', 'desc');
        if (auth()->user()->user_type == 'LABORATORY') {
            $list = $list->where('pharma_lab_id', auth()->user()->id)->where('type', 'LAB');
        } else if (auth()->user()->user_type == 'PHARMACIST') {

            $list = $list->where('pharma_lab_id', auth()->user()->id)->where('type', 'MED');
        } else if (auth()->user()->user_type == 'PATIENT') {

            $data = $request->validate([
                'type' => 'required|in:LAB,MED',
                'delivery_status' => 'nullable|in:Pending,In-Progress,Completed,Sample Collected',
            ]);
            $list = $list->where('user_id', auth()->user()->id)->where('type', $data['type']);

            if ($request->filled('delivery_status')) {
                $list = $list->where('delivery_status', $data['delivery_status']);
            }
        }

        try {
            $list = $list->with('quote:id,type,created_at,pharma_lab_id,quote_request_id')->paginate(Orders::$page); //Orders::$page
            if ($list->count() > 0) {

                $result = $list->toArray();
                $datas = $result['data'];
                foreach ($datas as $key => $data) {

                    $appointment = \DB::table('appointments')
                        ->leftJoin('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                        ->leftJoin('quotes', 'quotes.prescription_id', '=', 'prescriptions.id')
                        ->leftJoin('orders', 'orders.quote_id', '=', 'quotes.id')->where('orders.id', $data['id'])->select('appointments.appointment_unique_id', 'appointments.date')
                        ->get();
                    $data['appointment_unique_id'] = NULL;
                    $data['appointment_date'] = NULL;
                    if ($appointment->isNotEmpty()) {
                        $data['appointment_unique_id'] = $appointment->first()->appointment_unique_id;
                        $data['appointment_date'] = $appointment->first()->date;
                    }
                    unset($data['quote']['id']);
                    unset($data['quote']['type']);
                    unset($data['quote']['medicine']);
                    unset($data['quote']['test']);
                    unset($data['quote']['laboratory']);
                    unset($data['quote']['pharmacy']);
                    $datas[$key] = $data;
                }
                $result['data'] = $datas;
                return response()->json($result, 200);
            }
            return new ErrorMessage('Orders not found.', 404);
        } catch (\Exception $e) {
            return new ErrorMessage('Orders not found.', 404);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient Get orders
     *
     * @queryParam type required string MED for orders from pharmacy , LAB for orders from laboratory. APPOINTMENT for appointment list orders
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 74,
     *            "unique_id": "ORD0000074",
     *            "user_id": 3,
     *            "tax": 3.57,
     *            "subtotal": 396.5,
     *            "discount": 10,
     *            "delivery_charge": 50,
     *            "total": 440.07,
     *            "shipping_address_id": 75,
     *            "payment_status": "Paid",
     *            "delivery_status": "Pending",
     *            "delivery_info": null,
     *            "created_at": "2021-03-24 02:17:11 pm",
     *            "order_items": [
     *                {
     *                    "id": 77,
     *                    "item_id": 6,
     *                    "price": 65.5,
     *                    "quantity": 3,
     *                    "item_details": {
     *                        "id": 6,
     *                        "category_id": 1,
     *                        "sku": "MED0000006",
     *                        "composition": "Xylometazoline Hydrochloride Nasal Solution IP",
     *                        "weight": 50,
     *                        "weight_unit": "g",
     *                        "name": "Lidocaine ointment",
     *                        "manufacturer": "Novartis",
     *                        "medicine_type": "Topical medicines",
     *                        "drug_type": "Generic",
     *                        "qty_per_strip": 2,
     *                        "price_per_strip": 65.5,
     *                        "rate_per_unit": 10,
     *                        "rx_required": 0,
     *                        "short_desc": null,
     *                        "long_desc": null,
     *                        "cart_desc": null,
     *                        "image_name": "img_15.jpg",
     *                        "image_url": null
     *                    }
     *                },
     *                {
     *                    "id": 78,
     *                    "item_id": 7,
     *                    "price": 100,
     *                    "quantity": 2,
     *                    "item_details": {
     *                        "id": 7,
     *                        "category_id": 1,
     *                        "sku": "MED0000007",
     *                        "composition": "GlaxoSmithKline",
     *                        "weight": 100,
     *                        "weight_unit": "g",
     *                        "name": "Voltaren gel",
     *                        "manufacturer": "GlaxoSmithKline Consumer Health",
     *                        "medicine_type": "Topical medicines",
     *                        "drug_type": "Generic",
     *                        "qty_per_strip": 1,
     *                        "price_per_strip": 100,
     *                        "rate_per_unit": 10,
     *                        "rx_required": 0,
     *                        "short_desc": null,
     *                        "long_desc": null,
     *                        "cart_desc": null,
     *                        "image_name": "img_10.jpg",
     *                        "image_url": null
     *                    }
     *                }
     *            ],
     *            "payments": {
     *                "id": 314,
     *                "unique_id": "PAY0000314",
     *                "total_amount": 440.07,
     *                "payment_status": "Paid",
     *                "created_at": "2021-03-24 02:17:11 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=1",
     *    "from": 1,
     *    "last_page": 15,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=15",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/orders",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 15
     *}
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 58,
     *            "unique_id": "ORD0000058",
     *            "user_id": 3,
     *            "tax": 9.8,
     *            "subtotal": 200.5,
     *            "discount": 20.5,
     *            "delivery_charge": 100,
     *            "total": 289.8,
     *            "shipping_address_id": 75,
     *            "payment_status": "Paid",
     *            "delivery_status": "Pending",
     *            "delivery_info": null,
     *            "created_at": "2021-03-19 10:25:34 pm",
     *            "order_items": [
     *                {
     *                    "id": 60,
     *                    "item_id": 2,
     *                    "price": 200.5,
     *                    "quantity": 1,
     *                    "item_details": {
     *                        "id": 2,
     *                        "name": "Basic Metabolic Panel",
     *                        "unique_id": "LAT0000002",
     *                        "price": 200.5,
     *                        "currency_code": "INR",
     *                        "code": "BMP",
     *                        "image": null
     *                    }
     *                }
     *            ],
     *            "payments": {
     *                "id": 245,
     *                "unique_id": "PAY0000245",
     *                "total_amount": 289.8,
     *                "payment_status": "Paid",
     *                "created_at": "2021-03-19 10:25:34 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=1",
     *    "from": 1,
     *    "last_page": 3,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=3",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/orders",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 3
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 392,
     *            "appointment_unique_id": "AP0000392",
     *            "date": "2021-03-25",
     *            "time": "10:29:00",
     *            "consultation_type": "INCLINIC",
     *            "shift": null,
     *            "payment_status": "Paid",
     *            "total": 449.78,
     *            "tax": 11.78,
     *            "commission": 43.8,
     *            "is_cancelled": 0,
     *            "is_completed": 0,
     *            "followup_id": null,
     *            "booking_date": "2021-03-25",
     *            "payments": {
     *                "id": 320,
     *                "unique_id": "PAY0000320",
     *                "total_amount": 449.78,
     *                "payment_status": "Paid",
     *                "created_at": "2021-03-25 03:58:47 pm"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=1",
     *    "from": 1,
     *    "last_page": 33,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=33",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/patient/orders?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/patient/orders",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 33
     *}
     */
    public function patientGetOrderList(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:LAB,MED,APPOINTMENT',
        ]);

        if ($data['type'] != 'APPOINTMENT') {
            $list = Orders::where('type', $data['type'])->where('user_id', auth()->user()->id)->with('order_items')->with('payments')->orderBy('id', 'desc')->paginate(Orders::$page);

            if ($list->count() > 0) {
                $result = $list->toArray();
                $datas = $result['data'];

                foreach ($datas as $key => $data) {

                    $appointment = \DB::table('appointments')
                        ->leftJoin('prescriptions', 'appointments.id', '=', 'prescriptions.appointment_id')
                        ->leftJoin('quotes', 'quotes.prescription_id', '=', 'prescriptions.id')
                        ->leftJoin('orders', 'orders.quote_id', '=', 'quotes.id')->where('orders.id', $data['id'])->select('appointments.appointment_unique_id', 'appointments.date')
                        ->get();
                    $data['appointment_unique_id'] = NULL;
                    $data['appointment_date'] = NULL;
                    if ($appointment->isNotEmpty()) {
                        $data['appointment_unique_id'] = $appointment->first()->appointment_unique_id;
                        $data['appointment_date'] = $appointment->first()->date;
                    }
                    $datas[$key] = $data;
                }
                $result['data'] = $datas;
                return response()->json($result, 200);
            }
        } else {
            $list = Appointments::where('patient_id', auth()->user()->id)->with('payments')->whereHas('payments')->orderBy('id', 'desc')->paginate(Appointments::$page);

            if ($list->count() > 0) {
                $list->makeVisible('commission');
                $list->makeHidden(['doctor_id', 'patient_id', 'current_patient_info', 'patient_details', 'patient_more_info', 'start_time', 'end_time',]);
            }
            if ($list->count() > 0) {
                return response()->json($list, 200);
            }
        }
        return new ErrorMessage('Orders not found.', 404);
    }
    /**
     * @authenticated
     *
     * @group Patient
     *
     * Patient Get order by Id
     *
     * @queryParam id required integer id of order or appointment id
     * @queryParam type required string MED for orders from pharmacy , LAB for orders from laboratory. APPOINTMENT for appointment list orders
     *
     * @response 200 {
     *    "id": 392,
     *    "appointment_unique_id": "AP0000392",
     *    "date": "2021-03-25",
     *    "time": "10:29:00",
     *    "consultation_type": "INCLINIC",
     *    "shift": null,
     *    "payment_status": "Paid",
     *    "total": 449.78,
     *    "commission": 43.8,
     *    "tax": 11.78,
     *    "is_cancelled": 0,
     *    "is_completed": 0,
     *    "followup_id": null,
     *    "booking_date": "2021-03-25",
     *    "payments": {
     *        "id": 320,
     *        "unique_id": "PAY0000320",
     *        "total_amount": 449.78,
     *        "payment_status": "Paid",
     *        "created_at": "2021-03-25 03:58:47 pm"
     *    }
     *}
     *
     * @response 200 {
     *    "id": 58,
     *    "unique_id": "ORD0000058",
     *    "user_id": 3,
     *    "tax": 9.8,
     *    "subtotal": 200.5,
     *    "discount": 20.5,
     *    "delivery_charge": 100,
     *    "total": 289.8,
     *    "shipping_address_id": 75,
     *    "payment_status": "Paid",
     *    "delivery_status": "Pending",
     *    "delivery_info": null,
     *    "created_at": "2021-03-19 10:25:34 pm",
     *    "order_items": [
     *        {
     *            "id": 60,
     *            "item_id": 2,
     *            "price": 200.5,
     *            "quantity": 1,
     *            "item_details": {
     *                "id": 2,
     *                "name": "Basic Metabolic Panel",
     *                "unique_id": "LAT0000002",
     *                "price": 200.5,
     *                "currency_code": "INR",
     *                "code": "BMP",
     *                "image": null
     *            }
     *        }
     *    ],
     *    "payments": {
     *        "id": 245,
     *        "unique_id": "PAY0000245",
     *        "total_amount": 289.8,
     *        "payment_status": "Paid",
     *        "created_at": "2021-03-19 10:25:34 pm"
     *    }
     *}
     *
     * @response 200 {
     *    "id": 74,
     *    "unique_id": "ORD0000074",
     *    "user_id": 3,
     *    "tax": 3.57,
     *    "subtotal": 396.5,
     *    "discount": 10,
     *    "delivery_charge": 50,
     *    "total": 440.07,
     *    "shipping_address_id": 75,
     *    "payment_status": "Paid",
     *    "delivery_status": "Pending",
     *    "delivery_info": null,
     *    "created_at": "2021-03-24 02:17:11 pm",
     *    "order_items": [
     *        {
     *            "id": 77,
     *            "item_id": 6,
     *            "price": 65.5,
     *            "quantity": 3,
     *            "item_details": {
     *                "id": 6,
     *                "category_id": 1,
     *                "sku": "MED0000006",
     *                "composition": "Xylometazoline Hydrochloride Nasal Solution IP",
     *                "weight": 50,
     *                "weight_unit": "g",
     *                "name": "Lidocaine ointment",
     *                "manufacturer": "Novartis",
     *                "medicine_type": "Topical medicines",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 2,
     *                "price_per_strip": 65.5,
     *                "rate_per_unit": 10,
     *                "rx_required": 0,
     *                "short_desc": null,
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": "img_15.jpg",
     *                "image_url": null
     *            }
     *        },
     *        {
     *            "id": 78,
     *            "item_id": 7,
     *            "price": 100,
     *            "quantity": 2,
     *            "item_details": {
     *                "id": 7,
     *                "category_id": 1,
     *                "sku": "MED0000007",
     *                "composition": "GlaxoSmithKline",
     *                "weight": 100,
     *                "weight_unit": "g",
     *                "name": "Voltaren gel",
     *                "manufacturer": "GlaxoSmithKline Consumer Health",
     *                "medicine_type": "Topical medicines",
     *                "drug_type": "Generic",
     *                "qty_per_strip": 1,
     *                "price_per_strip": 100,
     *                "rate_per_unit": 10,
     *                "rx_required": 0,
     *                "short_desc": null,
     *                "long_desc": null,
     *                "cart_desc": null,
     *                "image_name": "img_10.jpg",
     *                "image_url": null
     *            }
     *        }
     *    ],
     *    "payments": {
     *        "id": 314,
     *        "unique_id": "PAY0000314",
     *        "total_amount": 440.07,
     *        "payment_status": "Paid",
     *        "created_at": "2021-03-24 02:17:11 pm"
     *    }
     *}
     */
    public function patientGetOrderById($id, Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:LAB,MED,APPOINTMENT',
        ]);

        if ($data['type'] != 'APPOINTMENT') {
            $list = Orders::where('type', $data['type'])->where('user_id', auth()->user()->id)->with('order_items')->with('payments')->where('id', $id)->first();
        } else {
            $list = Appointments::where('patient_id', auth()->user()->id)->with('payments')->whereHas('payments')->where('id', $id)->first();

            if ($list) {
                $list->makeHidden(['doctor_id', 'patient_id', 'current_patient_info', 'patient_details', 'patient_more_info', 'start_time', 'end_time',]);
                $list->makeVisible('commission');
            }
        }

        if ($list) {
            return response()->json($list, 200);
        }
        return new ErrorMessage('Orders not found.', 404);
    }

    /**
     * @authenticated
     *
     * @group Orders
     *
     * Get order details by Id  Patient, Pharmacy, Laboratory
     *
     * @queryParam id required integer id of order
     *
     * @response 200 {
     *    "id": 9,
     *    "unique_id": null,
     *    "user_id": 3,
     *    "tax": 10,
     *    "subtotal": 20,
     *    "discount": 2,
     *    "delivery_charge": 2,
     *    "total": 500.49,
     *    "shipping_address_id": 1,
     *    "payment_status": "Not Paid",
     *    "delivery_status": "Pending",
     *    "delivery_info": null,
     *    "created_at": "2021-03-08 03:16:16 pm",
     *    "quote": {
     *        "created_at": "2021-03-01 03:46:59 pm",
     *        "quote_from": {
     *            "id": 11,
     *            "name": "Lifeline Labs Pvt ltd",
     *            "address": [
     *                {
     *                    "id": 164,
     *                    "street_name": "Near sunshine Apartments",
     *                    "city_village": "Telengana",
     *                    "district": "Hyderabad",
     *                    "state": "Telangana",
     *                    "country": "India",
     *                    "pincode": "500001",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "land_mark": null,
     *                    "latitude": "17.38743640",
     *                    "longitude": "78.47217290",
     *                    "clinic_name": null
     *                }
     *            ]
     *        }
     *    },
     *    "quote_contact": {
     *        "id": 1,
     *        "country_code": "+91",
     *        "mobile_number": "8610025593",
     *        "profile_photo_url": null
     *    },
     *    "order_items": [
     *        {
     *            "id": 7,
     *            "item_id": 1,
     *            "price": 10,
     *            "quantity": 1,
     *            "item_details": {
     *                "id": 1,
     *                "name": "Blood New",
     *                "unique_id": "LAT0000001",
     *                "price": 555,
     *                "currency_code": "INR",
     *                "code": "BL New Test.",
     *                "image": null
     *            }
     *        }
     *    ],
     *    "billing_address": [
     *        {
     *            "id": 1,
     *            "street_name": "South Road",
     *            "city_village": "Edamatto",
     *            "district": "Kottayam",
     *            "state": "Kerala",
     *            "country": "India",
     *            "pincode": "686575",
     *            "country_code": null,
     *            "contact_number": "9786200983",
     *            "land_mark": null,
     *            "latitude": "10.53034500",
     *            "longitude": "76.21472900",
     *            "clinic_name": "Neo clinic"
     *        }
     *    ]
     *}
     * @response 200 {
     *    "id": 1,
     *    "user_id": 3,
     *    "tax": 10,
     *    "subtotal": 20,
     *    "discount": 2,
     *    "delivery_charge": 2,
     *    "total": 500.49,
     *    "shipping_address_id": 1,
     *    "payment_status": "Not Paid",
     *    "delivery_status": "Pending",
     *    "delivery_info": null,
     *    "created_at": "2021-03-02 06:29:02 pm",
     *    "order_items": [
     *        {
     *            "id": 1,
     *            "item_id": 1,
     *            "price": 10,
     *            "quantity": 1,
     *            "item_details": {
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
     *        }
     *    ]
     *}
     *
     * @response 404 {
     *    "message": "OrderId not found."
     *}
     */
    public function getOrderById($id, Request $request)
    {

        $list = Orders::where('id', $id);

        if (auth()->user()->user_type == 'LABORATORY') {
            $list = $list->where('pharma_lab_id', auth()->user()->id)->where('type', 'LAB');
        } else if (auth()->user()->user_type == 'PHARMACIST') {

            $list = $list->where('pharma_lab_id', auth()->user()->id)->where('type', 'MED');
        } else if (auth()->user()->user_type == 'PATIENT') {
            $list = $list->where('user_id', auth()->user()->id)->with('quote:id,type,created_at,pharma_lab_id,quote_request_id')->with('quote_contact:id,country_code,mobile_number');
        }
        try {
            $list = $list->with('order_items')->with('billing_address')->firstOrFail();

            $result = $list->toArray();
            unset($result['quote']['id']);
            unset($result['quote']['type']);
            unset($result['quote']['medicine']);
            unset($result['quote']['test']);
            unset($result['quote']['laboratory']);
            unset($result['quote']['pharmacy']);
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            return new ErrorMessage('OrderId not found.', 404);
        }
    }
    /**
     * @authenticated
     *
     * @group Orders
     *
     * Edit order details by Id
     *
     * @bodyParam delivery_status string required In-Progress or Completed
     * @bodyParam delivery_info string required
     *
     * @bodyParam sample array required
     * @bodyParam sample.date date required format-> Y-m-d
     * @bodyParam sample.time string required format 10:30 AM
     * @bodyParam sample.name string required

     *
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "delivery_status": [
     *            "The delivery status field is required."
     *        ],
     *        "sample.date": [
     *            "The sample.date field is required."
     *        ],
     *        "sample.time": [
     *            "The sample.time does not match the format h:i A."
     *        ],
     *        "sample.name": [
     *            "The sample.name field is required."
     *        ]
     *    }
     *}
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "delivery_status": [
     *            "The delivery status field is required."
     *        ],
     *        "delivery_info": [
     *            "The delivery info field must be present."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "order updated successfully."
     *}
     * @response 404 {
     *     "message": "Order not found."
     * }
     */
    public function editOrder($id, Request $request)
    {
        if (auth()->user()->user_type == 'LABORATORY') {
            $rules = [
                'delivery_status' => 'required|in:In-Progress,Completed,Sample Collected',

                //for in-progress status
                'sample' => 'array|required_if:delivery_status,Sample Collected',
                'sample.date' => 'required_if:delivery_status,Sample Collected|date_format:Y-m-d',
                'sample.time' => 'required_if:delivery_status,Sample Collected',
                'sample.name' => 'required_if:delivery_status,Sample Collected|string',

                //for completed status it is required
                'delivery_info' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ];
        } else {
            $rules = [
                'delivery_status' => 'required|in:In-Progress,Completed',
                'delivery_info' => 'present|required_if:delivery_status,In-Progress',
                //it is required
                'bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ];
        }
        $data = $request->validate($rules);
        $delivery_info  = NULL;
        $record = Orders::where('id', $id);
        if (auth()->user()->user_type == 'LABORATORY') {
            $record = $record->where('pharma_lab_id', auth()->user()->id)->where('type', 'LAB');
            $record = $record->firstOrFail();
            if ($request->file('delivery_info')) {
                $fileExtension = $request->delivery_info->extension();
                $uuid = Str::uuid()->toString();
                $folder = 'public/uploads/labreport';
                $filePath = $request->file('delivery_info')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
                $delivery_info  = $filePath;
                $record->delivery_info = $delivery_info;
            }

            if ($data['delivery_status'] == 'Sample Collected') {
                $record->sample_collect = $data['sample'];
            }
        } else if (auth()->user()->user_type == 'PHARMACIST') {
            $record = $record->where('pharma_lab_id', auth()->user()->id)->where('type', 'MED');
            $record = $record->firstOrFail();
            if ($data['delivery_status'] == 'In-Progress') {
                $record->delivery_info = $data['delivery_info'];
            }
        }
        //bill path
        try {
            $record->delivery_status = $data['delivery_status'];

            if ($request->file('bill')) {
                $fileExtension = $request->bill->extension();
                $uuid = Str::uuid()->toString();
                $folder = 'public/uploads/bills';
                $bill_path = $request->file('bill')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);
                $record->bill_path = $bill_path;
            }
            $record->save();
            return new SuccessMessage('Order updated successfully.', 200);
        } catch (\Exception $exception) {
            return new ErrorMessage('Order not found.', 422);
        }
    }

    /**
     * @authenticated
     *
     * @group Patient
     *
     * Cancel order by Id
     *
     * @bodyParam order_id integer required  id of order
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "order_id": [
     *            "The selected order id is invalid."
     *        ]
     *    }
     *}
     *
     *
     * @response 200 {
     *    "message": "order cancelled successfully."
     *}
     * @response 404 {
     *     "message": "Order can't be cancelled."
     * }
     */
    public function cancelOrder(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'exists:orders,id'
        ]);

        $record = Orders::with('payments')->with('quote_contact')->find($data['order_id']);

        if ($record->delivery_status == 'Pending') {
            (new PaymentService)->refund($record, 'ORDER');

            $record->payment_status = 'Refund';
            $record->delivery_status = 'Cancelled';
            $record->save();
            $message = "Your order " . $record->unique_id . " has been cancelled.";

            SendEmailJob::dispatch(['user_name' => auth()->user()->last_name, 'email' => auth()->user()->email, 'mail_type' => 'notification', 'message' => $message]);

            SendEmailJob::dispatch(['user_name' => $record->quote_contact->last_name, 'email' => $record->quote_contact->email, 'mail_type' => 'notification', 'message' => $message]);

            return new SuccessMessage('Order cancelled successfully.', 200);
        }
        return new ErrorMessage('Order can\'t be cancelled.', 403);
    }
}
