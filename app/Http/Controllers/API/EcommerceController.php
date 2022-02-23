<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EcommerceRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Cart;
use App\Model\PrescriptionMedList;
use App\Model\Prescriptions;
use App\Model\PrescriptionTestList;
use Illuminate\Http\Request;
use Str;

class EcommerceController extends Controller
{
    /**
     * @authenticated
     *
     * @group Ecommerce
     *
     * Cart checkout
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam cart_id integer required
     * @bodyParam prescription_file file nullable File mime:pdf,jpg,jpeg,png size max 2mb
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "cart_id": [
     *            "The cart id field is required."
     *        ],
     *        "prescription_file": [
     *            "The prescription file must be a file.",
     *            "The prescription file must be a file of type: jpg, jpeg, png, pdf."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "prescription_id": 49
     *}
     * @response 422 {
     *    "message": "Something went wrong."
     *}
     */
    public function checkOutOrder(EcommerceRequest $request)
    {
        $data = $request->validated();
        $items = Cart::with('cart_items')->find($data['cart_id']);
        $file_path = NULL;
        if ($request->file('prescription_file')) {
            $fileExtension = $request->prescription_file->extension();
            $uuid = Str::uuid()->toString();
            $folder = 'public/uploads/ecommerce';
            $filePath = $request->file('prescription_file')->storeAs($folder, time() . '-' . $uuid . '.' . $fileExtension);

            $file_path  = $filePath;
        }
        if ($items->type == 'MED') {
            try {

                $medicine_list = array();
                foreach ($items->cart_items as $key => $item) {
                    $list['quantity'] = $item->quantity;
                    $list['medicine_id'] = $item->item_id;
                    $list['status'] = 2;
                    $medicine_list[] = $list;
                }
                //make entry in prescription
                $prescription = Prescriptions::create(
                    [
                        'user_id' => auth()->user()->id,
                        'unique_id' => getPrescriptionId(),
                        'medicine_list' => $medicine_list,
                        'purchase_type' => 'Ecommerce_MED',
                        'file_path' => $file_path
                    ]
                );
                //listing for quote
                foreach ($medicine_list as $key => $med_list) {
                    PrescriptionMedList::create(
                        [
                            'prescription_id' => $prescription->id,
                            'medicine_id' => $med_list['medicine_id'],
                            'quantity' => $med_list['quantity'],
                            'status' => $med_list['status'],
                        ]
                    );
                }
                return response()->json(['prescription_id' => $prescription->id], 200);
            } catch (\Exception $exception) {
                \Log::error(['checkOutOrder medicine EXCEPTION' => $exception->getMessage()]);
                return new ErrorMessage('Something went wrong.', 422);
            }
        } else {
            try {
                $data = $request->validated();
                $items = Cart::with('cart_items')->find($data['cart_id']);
                $test_list = array();
                foreach ($items->cart_items as $key => $item) {
                    $list['lab_test_id'] = $item->item_id;
                    $list['status'] = 2;
                    $test_list[] = $list;
                }
                //make entry in prescription
                $prescription = Prescriptions::create(
                    [
                        'user_id' => auth()->user()->id,
                        'unique_id' => getPrescriptionId(),
                        'test_list' => $test_list,
                        'purchase_type' => 'Ecommerce_LAB',
                        'file_path' => $file_path
                    ]
                );
                //listing for quote
                foreach ($test_list as $key => $value) {
                    PrescriptionTestList::create(
                        [
                            'prescription_id' => $prescription->id,
                            'lab_test_id' => $value['lab_test_id'],
                            'status' => $value['status'],
                        ]
                    );
                }
                return response()->json(['prescription_id' => $prescription->id], 200);
            } catch (\Exception $exception) {
                \Log::error(['checkOutOrder lab test EXCEPTION' => $exception->getMessage()]);
                return new ErrorMessage('Something went wrong.', 422);
            }
        }
    }
}
