<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicineRequest;
use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Model\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin list Medicine
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "category_id": 1,
     *            "sku": "MED0000001",
     *            "composition": "paracet",
     *            "weight": 0.5,
     *            "weight_unit": "mg",
     *            "name": "Dolo",
     *            "manufacturer": "Inc",
     *            "medicine_type": "Tablet",
     *            "drug_type": "Generic",
     *            "qty_per_strip": 10,
     *            "price_per_strip": 200,
     *            "rate_per_unit": 10,
     *            "rx_required": 1,
     *            "short_desc": "Take for fever",
     *            "long_desc": null,
     *            "cart_desc": null,
     *            "image_name": "tiger.jpg",
     *            "image_url": "http://localhost/fms-api-laravel/public/storage/uploads/medicine/1608041755tiger.jpg"
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine?page=1",
     *    "from": 1,
     *    "last_page": 3,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine?page=3",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/medicine",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 3
     *}
     * @response 200 [
     *    {
     *        "id": 1,
     *        "category_id": 1,
     *        "sku": "MED0000001",
     *        "composition": "paracet",
     *        "weight": 0.5,
     *        "weight_unit": "mg",
     *        "name": "Dolo",
     *        "manufacturer": "Inc",
     *        "medicine_type": "Tablet",
     *        "drug_type": "Generic",
     *        "qty_per_strip": 10,
     *        "price_per_strip": 200,
     *        "rate_per_unit": 10,
     *        "rx_required": 1,
     *        "short_desc": "Take for fever",
     *        "long_desc": null,
     *        "cart_desc": null,
     *        "image_name": "tiger.jpg",
     *        "image_url": "http://localhost/fms-api-laravel/public/storage/uploads/medicine/1608041755tiger.jpg"
     *    }
     *]
     * @response 404 {
     *    "message": "Medicine not found."
     *}
     */
    public function index(Request $request)
    {
        $request->validate([
            'paginate' => 'nullable|in:0',
        ]);
        if ($request->filled('paginate')) {
            $list = Medicine::all();
        } else {
            $list = Medicine::orderBy('id', 'desc')->paginate(Medicine::$page);
        }
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("Medicine not found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin add Medicine
     *
     * Authorization: "Bearer {access_token}"
     *
     * @bodyParam category_id integer required id of category
     * @bodyParam composition string required
     * @bodyParam weight float required
     * @bodyParam weight_unit string required
     * @bodyParam name string required unique
     * @bodyParam manufacturer string required
     * @bodyParam medicine_type string required
     * @bodyParam drug_type string required Generic/Branded
     * @bodyParam currency_code string required
     * @bodyParam price_per_strip integer required
     * @bodyParam qty_per_strip integer required
     * @bodyParam rate_per_unit double required
     * @bodyParam rx_required boolean required 0 or 1
     * @bodyParam short_desc string nullable
     * @bodyParam long_desc string nullable
     * @bodyParam cart_desc string nullable
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     *
     * @response 200 {
     *    "message": "Medicine added successfully."
     *}
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "category_id": [
     *            "The category id field is required."
     *        ],
     *        "composition": [
     *            "The composition field is required."
     *        ],
     *        "weight": [
     *            "The weight field is required."
     *        ],
     *        "weight_unit": [
     *            "The weight unit field is required."
     *        ],
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "manufacturer": [
     *            "The manufacturer field is required."
     *        ],
     *        "medicine_type": [
     *            "The medicine type field is required."
     *        ],
     *        "drug_type": [
     *            "The drug type field is required."
     *        ],
     *        "price_per_strip": [
     *            "The price per strip field is required."
     *        ],
     *        "qty_per_strip": [
     *            "The qty per strip field is required."
     *        ],
     *        "rate_per_unit": [
     *            "The rate per unit field is required."
     *        ],
     *        "rx_required": [
     *            "The rx required field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Medicine added successfully.."
     *}
     */
    public function store(MedicineRequest $request)
    {
        $data = $request->validated();
        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/medicine';
            $image_name = time() . $fileName;
            $filePath = $request->file('image')->storeAs($folder, $image_name);
            $data['image_path'] = json_encode(array(array('image_name' => $image_name)));
            $data['image_name'] = $fileName;
        }
        auth()->user()->update(['currency_code' => $data['currency_code']]);
        unset($data['image']);
        unset($data['currency_code']);
        $data['sku'] = getMedicineSKU();
        $data['created_by'] = auth()->user()->id;
        Medicine::create($data);
        return new SuccessMessage('Medicine added successfully.');
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin update Medicine
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @bodyParam category_id integer required id of category
     * @bodyParam composition string required
     * @bodyParam weight float required
     * @bodyParam weight_unit string required
     * @bodyParam name string required unique
     * @bodyParam manufacturer string required
     * @bodyParam medicine_type string required
     * @bodyParam drug_type string required Generic/Branded
     * @bodyParam currency_code string required
     * @bodyParam price_per_strip integer required
     * @bodyParam qty_per_strip integer required
     * @bodyParam rate_per_unit double required
     * @bodyParam rx_required boolean required 0 or 1
     * @bodyParam short_desc string nullable
     * @bodyParam long_desc string nullable
     * @bodyParam cart_desc string nullable
     * @bodyParam image file nullable mimes:jpg,jpeg,png max:2mb
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "category_id": [
     *            "The category id field is required."
     *        ],
     *        "composition": [
     *            "The composition field is required."
     *        ],
     *        "weight": [
     *            "The weight field is required."
     *        ],
     *        "weight_unit": [
     *            "The weight unit field is required."
     *        ],
     *        "name": [
     *            "The name field is required."
     *        ],
     *        "manufacturer": [
     *            "The manufacturer field is required."
     *        ],
     *        "medicine_type": [
     *            "The medicine type field is required."
     *        ],
     *        "drug_type": [
     *            "The drug type field is required."
     *        ],
     *        "price_per_strip": [
     *            "The price per strip field is required."
     *        ],
     *        "qty_per_strip": [
     *            "The qty per strip field is required."
     *        ],
     *        "rate_per_unit": [
     *            "The rate per unit field is required."
     *        ],
     *        "rx_required": [
     *            "The rx required field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 {
     *    "message": "Medicine updated successfully.."
     *}
     * @response 404 {
     *    "message": "Medicine not found."
     *}
     */
    public function update(MedicineRequest $request, $id)
    {
        try {
            $medicine = Medicine::findOrFail($id);
        } catch (\Exception $e) {
            return new ErrorMessage('Medicine not found.', 404);
        }

        $data = $request->validated();
        if ($request->file('image')) {
            $fileName = $request->image->getClientOriginalName();
            $folder = 'public/uploads/medicine';
            $image_name = time() . $fileName;
            $filePath = $request->file('image')->storeAs($folder, $image_name);
            $data['image_path'] = json_encode(array(array('image_name' => $image_name)));
            $data['image_name'] = $fileName;
        }
        auth()->user()->update(['currency_code' => $data['currency_code']]);
        unset($data['currency_code']);
        unset($data['image']);
        $data['updated_by'] = auth()->user()->id;
        $medicine->update($data);
        return new SuccessMessage('Medicine updated successfully.');
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin delete Medicine by id
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam id required integer id of record
     *
     * @response 200 {
     *    "message": "Medicine deleted successfully."
     *}
     * @response 404 {
     *    "message": "Medicine not found."
     *}
     */
    public function delete($id)
    {
        try {
            $medicine = Medicine::findOrFail($id);

            // if ($medicine->parent()->exists()) {
            //     return new ErrorMessage('Medicine can not be deleted.', 404);
            // }
            $medicine->delete();
            return new SuccessMessage('Medicine deleted successfully.');
        } catch (\Exception $exception) {
            return new ErrorMessage('Medicine not found.', 404);
        }
    }

    /**
     *
     * @group Search
     *
     * User search Medicine
     *
     * @queryParam name nullable string
     * @queryParam category nullable string
     * @queryParam paginate nullable integer nullable paginate = 0
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "name": [
     *            "The name field is required."
     *        ]
     *    }
     *}
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "category_id": 1,
     *        "sku": "MED0000001",
     *        "composition": "paracet",
     *        "weight": 0.5,
     *        "weight_unit": "mg",
     *        "name": "cita",
     *        "manufacturer": "Inc",
     *        "medicine_type": "Tablet",
     *        "drug_type": "Generic",
     *        "qty_per_strip": 10,
     *        "price_per_strip": 200,
     *        "rate_per_unit": 10,
     *        "rx_required": 1,
     *        "short_desc": "Take for fever",
     *        "long_desc": null,
     *        "cart_desc": null,
     *        "image_name": "tiger.jpg",
     *        "image_url": "http://localhost/fms-api-laravel/public/storage/uploads/medicine/1608640035tiger.jpg",
     *        "category": {
     *            "id": 1,
     *            "parent_id": null,
     *            "name": "Tablets"
     *        }
     *    }
     *]
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "category_id": 1,
     *            "sku": "MED0000001",
     *            "composition": "paracet",
     *            "weight": 0.5,
     *            "weight_unit": "mg",
     *            "name": "cita",
     *            "manufacturer": "Inc",
     *            "medicine_type": "Tablet",
     *            "drug_type": "Generic",
     *            "qty_per_strip": 10,
     *            "price_per_strip": 200,
     *            "rate_per_unit": 10,
     *            "rx_required": 1,
     *            "short_desc": "Take for fever",
     *            "long_desc": null,
     *            "cart_desc": null,
     *            "image_name": "tiger.jpg",
     *            "image_url": "http://localhost/fms-api-laravel/public/storage/uploads/medicine/1608640035tiger.jpg",
     *            "category": {
     *                "id": 1,
     *                "parent_id": null,
     *                "name": "Tablets"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine/search?page=1",
     *    "from": 1,
     *    "last_page": 3,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine/search?page=3",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/admin/medicine/search?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/medicine/search",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 3
     *}
     * @response 404 {
     *    "message": "Medicine not found."
     *}
     */
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'nullable',
            'category' => 'nullable',
            'paginate' => 'nullable|in:0',
        ]);
        $medicine = Medicine::when($request->filled('name'),function($query) use ($request) {
            $query->where(function($subquery) use ($request){
                    $subquery->where('name', 'like', $request->name . '%')
                            ->orWhere('composition', 'like', $request->name . '%')
                            ->orWhere('manufacturer', 'like', $request->name . '%');
                });
        })
        ->whereHas('category', function ($query) use ($request) {
            $query->when($request->filled('category'),function($subquery) use ($request){
                $subquery->where('name', 'like', $request->category . '%');
            });
        })
        ->with('category');

        if ($request->filled('paginate')) {
            $medicine = $medicine->orderBy('id', 'desc')->get();
        } else {
            $medicine = $medicine->orderBy('id', 'desc')->paginate(Medicine::$page);
        }

        if ($medicine->count() > 0) {
            return response()->json($medicine, 200);
        }
        return new ErrorMessage('Medicine not found.', 404);
    }

    /**
     *
     * @group General
     *
     * Get Medicine details by Id
     *
     * @queryParam id required integer id of medicine
     *
     * @response 200 {
     *    "id": 11,
     *    "category_id": 1,
     *    "sku": "MED0000011",
     *    "composition": "paracet",
     *    "weight": 0.5,
     *    "weight_unit": "mg",
     *    "name": "Crocin",
     *    "manufacturer": "Inc",
     *    "medicine_type": "Tablet",
     *    "drug_type": "Generic",
     *    "qty_per_strip": 10,
     *    "price_per_strip": 200,
     *    "rate_per_unit": 10,
     *    "rx_required": 1,
     *    "short_desc": "Take for fever",
     *    "long_desc": null,
     *    "cart_desc": null,
     *    "image_name": null,
     *    "image_url": null,
     *    "category": {
     *        "id": 1,
     *        "parent_id": null,
     *        "name": "Tablet",
     *        "image_url": null
     *    }
     *}
     * @response 404 {
     *     "message": "Medicine not found."
     * }
     */
    public function getMedicineById($id)
    {
        try {
            $medicine = Medicine::with('category')->findOrFail($id);
            return response()->json($medicine, 200);
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
            return new ErrorMessage('Medicine not found.', 404);
        }
    }
}
