<?php

namespace App\Http\Controllers\API\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorMessage;
use App\Http\Services\ImportService;
use App\Model\Appointments;
use App\Model\DoctorPersonalInfo;
use App\Model\Employee;
use App\Model\LaboratoryInfo;
use App\Model\PatientPersonalInfo;
use App\Model\Pharmacy;
use App\Model\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin, Employee  list Doctor
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[name]='text', filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
     * @queryParam report nullable send 1 to download as excel
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "user_id": 2,
     *            "doctor_unique_id": "D0000001",
     *            "title": "Dr.",
     *            "gender": "MALE",
     *            "date_of_birth": "1993-06-19",
     *            "age": 4,
     *            "qualification": "BA",
     *            "years_of_experience": "5",
     *            "alt_country_code": "+91",
     *            "alt_mobile_number": null,
     *            "clinic_name": "GRACE",
     *            "career_profile": null,
     *            "education_training": null,
     *            "experience": null,
     *            "clinical_focus": null,
     *            "awards_achievements": null,
     *            "memberships": null,
     *            "appointment_type_online": null,
     *            "appointment_type_offline": null,
     *            "consulting_online_fee": 607,
     *            "consulting_offline_fee": 240,
     *            "emergency_fee": null,
     *            "emergency_appointment": null,
     *            "available_from_time": null,
     *            "available_to_time": null,
     *            "service": null,
     *            "no_of_followup": null,
     *            "followups_after": null,
     *            "cancel_time_period": 12,
     *            "reschedule_time_period": 24,
     *            "doctor_profile_photo": null,
     *            "user": {
     *                "id": 2,
     *                "first_name": "theo",
     *                "middle_name": "Heart",
     *                "last_name": "lineee",
     *                "email": "theophilus@logidots.com",
     *                "username": "theo",
     *                "country_code": "+91",
     *                "mobile_number": "8940330536",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "profile_photo_url": null
     *            },
     *            "address": [
     *                {
     *                    "id": 1,
     *                    "street_name": "North Road",
     *                    "city_village": "Nemmara",
     *                    "district": "Palakkad",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "627672",
     *                    "country_code": "+91",
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": "klein"
     *                },
     *                {
     *                    "id": 2,
     *                    "street_name": "South Road",
     *                    "city_village": "Edamattom",
     *                    "district": "Kottayam",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "686575",
     *                    "country_code": "+91",
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": "conroy"
     *                }
     *            ],
     *            "bank_account_details": [
     *                  {
     *                    "id": 2,
     *                    "bank_account_number": "BANK12345",
     *                    "bank_account_holder": "BANKER",
     *                    "bank_name": "BANK",
     *                    "bank_city": "India",
     *                    "bank_ifsc": "IFSC45098",
     *                    "bank_account_type": "SAVINGS"
     *                }
     *             ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/doctor?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/doctor?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/list/doctor",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listDoctor(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.approved' => 'nullable|in:0,1,2',
            'filter.city' => 'nullable',
            'report' => 'nullable|in:1',
        ]);

        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }

        $list = DoctorPersonalInfo::with('user')->whereHas('user', function ($query) use ($filter) {

            if (array_key_exists('approved', $filter) && $filter['approved'] != '') {

                $query->where('is_active', $filter['approved']);
            }

            if (array_key_exists('name', $filter) && $filter['name'] != '') {

                $query->where('first_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('middle_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('last_name', 'like', '%' . $filter['name'] . '%');
            }

            if (auth()->user()->hasRole('health_associate')) {
                $query->where('created_by', auth()->user()->id);
            }
        })->with('address');

        if (array_key_exists('city', $filter) && $filter['city'] != '') {
            $list = $list->whereHas('address', function ($query) use ($filter) {
                $query->where('city_village', 'like', '%' . $filter['city'] . '%');
            });
        }

        $list = $list->with('bankAccountDetails')->orderBy('id', 'desc');

        if ($request->filled('report')) {

            $list = $list->get();
            if ($list->count() > 0) {
                $input_to_excel_sheet = array();
                $input_to_excel_sheet[] = array('Doctor Id', 'Doctor Name', 'Mobile No', 'Email', 'Country', 'State', 'City/Village', 'Date of Approval', 'Status');

                foreach ($list as $key => $user) {
                    $address = array('country' => '', 'state' => '', 'city' => '');
                    if (!is_null($user->address->first())) {
                        $address['country'] = $user->address->first()->country;
                        $address['state'] = $user->address->first()->state;
                        $address['city'] = $user->address->first()->city_village;
                    }
                    $input_to_excel_sheet[] = array(
                        0 => $user->doctor_unique_id,
                        1 => $user->user->first_name . ' ' . $user->user->middle_name . ' ' . $user->user->last_name,
                        2 => $user->user->country_code . ' ' . $user->user->mobile_number,
                        3 => $user->user->email,
                        4 => $address['country'],
                        5 => $address['state'],
                        6 => $address['city'],
                        7 => $user->user->approved_date,
                        8 => $user->user->is_active == 1 ? 'Active' : 'Inactive',
                    );
                }
                $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
                return response()->download($excel['attach_file_path']);
            }
            return new ErrorMessage("No records found.", 404);
        }

        $list = $list->paginate(DoctorPersonalInfo::$page);
        if ($list->count() > 0) {
            $list->makeVisible('added_by');
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin, Employee list Pharmacy
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[name]='text' filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
     * @queryParam paginate nullable integer  paginate = 0
     * @queryParam report nullable send 1 to download as excel
     *
     * @response 200 [
     *    {
     *        "id": 1,
     *        "pharmacy_name": "Pharmacy Name",
     *        "pharmacy_unique_id": "PHA0000001"
     *    },
     *    {
     *        "id": 2,
     *        "pharmacy_name": "Grace",
     *        "pharmacy_unique_id": "PHA0000002"
     *    }
     *]
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "pharmacy_unique_id": "PHA0000001",
     *            "gstin": "GSTN49598E4",
     *            "dl_number": "LAB12345",
     *            "dl_issuing_authority": "AIMS",
     *            "dl_date_of_issue": "2020-10-15",
     *            "dl_valid_upto": "2030-10-15",
     *            "pharmacy_name": "Pharmacy Name",
     *            "pharmacist_name": "Prof. Tomas Ward MD",
     *            "course": "Bsc",
     *            "pharmacist_reg_number": "PHAR1234",
     *            "issuing_authority": "GOVT",
     *            "alt_mobile_number": null,
     *            "alt_country_code": null,
     *            "reg_date": "2020-10-15",
     *            "reg_valid_upto": "2030-10-15",
     *            "home_delivery": 0,
     *            "order_amount": "300.00",
     *            "dl_file": "http://localhost/fms-api-laravel/public/storage",
     *            "reg_certificate": "http://localhost/fms-api-laravel/public/storage",
     *            "user": {
     *                "id": 29,
     *                "first_name": "Alaina Hessel",
     *                "middle_name": "Burley Mertz",
     *                "last_name": "Prof. Tomas Ward MD",
     *                "email": "ziemann.dawn@example.com",
     *                "username": "isaac.abbott",
     *                "country_code": "+91",
     *                "mobile_number": "+1-496-551-6560",
     *                "user_type": "PHARMACIST",
     *                "is_active": "1",
     *                "profile_photo_url": null
     *            },
     *            "bank_account_details": [
     *                {
     *                    "id": 2,
     *                    "bank_account_number": "BANK12345",
     *                    "bank_account_holder": "BANKER",
     *                    "bank_name": "BANK",
     *                    "bank_city": "India",
     *                    "bank_ifsc": "IFSC45098",
     *                    "bank_account_type": "SAVINGS"
     *                }
     *            ],
     *            "address": [
     *                {
     *                    "id": 74,
     *                    "street_name": "East Road",
     *                    "city_village": "Edamon",
     *                    "district": "Kollam",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "691307",
     *                    "country_code": "+91",
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": null
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/pharmacy?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/pharmacy?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/list/pharmacy",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *    "message": "No records found."
     *}
     */
    public function listPharmacy(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.approved' => 'nullable|in:0,1,2',
            'filter.city' => 'nullable',
            'paginate' => 'nullable|in:0',
            'report' => 'nullable|in:1',
        ]);
        if ($request->filled('paginate')) {
            $list = Pharmacy::select('id', 'pharmacy_name', 'pharmacy_unique_id')->whereHas('user', function ($query) {
                $query->where('is_active', '1');
            })->orderBy('id', 'desc')->get();
            if ($list->count() > 0) {
                $list->makeHidden('dl_file');
                $list->makeHidden('reg_certificate');
                return response()->json($list, 200);
            }
            return new ErrorMessage("No records found.", 404);
        }

        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }

        $list = Pharmacy::with('user')->whereHas('user', function ($query) use ($filter) {

            if (array_key_exists('approved', $filter) && $filter['approved'] != '') {

                $query->where('is_active', $filter['approved']);
            }
            if (auth()->user()->hasRole('health_associate')) {
                $query->where('created_by', auth()->user()->id);
            }
        })->with('bankAccountDetails')->with('address');

        $list = $list->where(function ($query) use ($filter) {
            if (array_key_exists('name', $filter) && $filter['name'] != '') {
                $query->where('pharmacy_name', 'like', '%' . $filter['name'] . '%');
            }
        });

        if (array_key_exists('city', $filter) && $filter['city'] != '') {
            $list = $list->whereHas('address', function ($query) use ($filter) {
                $query->where('city_village', 'like', '%' . $filter['city'] . '%');
            });
        }
        $list = $list->orderBy('id', 'desc');

        if ($request->filled('report')) {

            $list = $list->get();
            if ($list->count() > 0) {
                $input_to_excel_sheet = array();
                $input_to_excel_sheet[] = array('Pharmacy Id', 'Pharmacy Name', 'Mobile No', 'Email', 'Country', 'State', 'City/Village', 'Date of Approval', 'Status');

                foreach ($list as $key => $user) {
                    $address = array('country' => '', 'state' => '', 'city' => '');
                    if (!is_null($user->address->first())) {
                        $address['country'] = $user->address->first()->country;
                        $address['state'] = $user->address->first()->state;
                        $address['city'] = $user->address->first()->city_village;
                    }
                    $input_to_excel_sheet[] = array(
                        0 => $user->pharmacy_unique_id,
                        1 => $user->user->first_name . ' ' . $user->user->middle_name . ' ' . $user->user->last_name,
                        2 => $user->user->country_code . ' ' . $user->user->mobile_number,
                        3 => $user->user->email,
                        4 => $address['country'],
                        5 => $address['state'],
                        6 => $address['city'],
                        7 => $user->user->approved_date,
                        8 => $user->user->is_active == 1 ? 'Active' : 'Inactive',
                    );
                }
                $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
                return response()->download($excel['attach_file_path']);
            }
            return new ErrorMessage("No records found.", 404);
        }
        $list = $list->paginate(Pharmacy::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin, Employee list Laboratory
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[name]='text' filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list
     * @queryParam paginate nullable integer paginate = 0
     * @queryParam report nullable send 1 to download as excel
     * @response 200 [
     *    {
     *        "id": 1,
     *        "laboratory_unique_id": "LAB0000001",
     *        "laboratory_name": "theo"
     *    },
     *    {
     *        "id": 2,
     *        "laboratory_unique_id": "LAB0000002",
     *        "laboratory_name": "Grace"
     *    }
     *]
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "laboratory_unique_id": "LAB0000001",
     *            "laboratory_name": "Laboratory Name",
     *            "alt_mobile_number": null,
     *            "alt_country_code": null,
     *            "gstin": "GSTN49598E4",
     *            "lab_reg_number": "LAB12345",
     *            "lab_issuing_authority": "AIMS",
     *            "lab_date_of_issue": "2020-10-15",
     *            "lab_valid_upto": "2030-10-15",
     *            "sample_collection": 0,
     *            "order_amount": null,
     *            "lab_tests": [
     *                {
     *                    "id": 1,
     *                    "sample_collect": 1
     *                }
     *            ],
     *            "lab_file": null,
     *            "user": {
     *                "id": 28,
     *                "first_name": "Garnett Kozey I",
     *                "middle_name": "Shyann Nienow",
     *                "last_name": "Monique Russel",
     *                "email": "runte.guadalupe@example.com",
     *                "username": "micaela66",
     *                "country_code": "+91",
     *                "mobile_number": "363.332.7484 x6886",
     *                "user_type": "LABORATORY",
     *                "is_active": "0",
     *                "profile_photo_url": null,
     *                "approved_by": "Jon"
     *            },
     *            "bank_account_details": [
     *                {
     *                    "id": 1,
     *                    "bank_account_number": "BANK12345",
     *                    "bank_account_holder": "BANKER",
     *                    "bank_name": "BANK",
     *                    "bank_city": "India",
     *                    "bank_ifsc": "IFSC45098",
     *                    "bank_account_type": "SAVINGS"
     *                }
     *            ],
     *            "address": [
     *                {
     *                    "id": 73,
     *                    "street_name": "East Road",
     *                    "city_village": "Edamon",
     *                    "district": "Kollam",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "691307",
     *                    "country_code": "+91",
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": null
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/laboratory?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/laboratory?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/list/laboratory",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *     "message": "No records found."
     *}
     */
    public function listLaboratory(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.approved' => 'nullable|in:0,1,2',
            'paginate' => 'nullable|in:0',
            'report' => 'nullable|in:1',
        ]);

        if ($request->filled('paginate')) {
            $list = LaboratoryInfo::select('id', 'laboratory_unique_id', 'laboratory_name')->whereHas('user', function ($query) {

                $query->where('is_active', '1');
            })->orderBy('id', 'desc')->get();
            if ($list->count() > 0) {
                $list->makeHidden('lab_file');
                //$list->makeHidden('reg_certificate');
                return response()->json($list, 200);
            }
            return new ErrorMessage("No records found.", 404);
        }

        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }

        $list = LaboratoryInfo::with('user')->whereHas('user', function (Builder $query) use ($filter) {
            if (array_key_exists('approved', $filter) && $filter['approved'] != '') {

                $query->where('is_active', $filter['approved']);
            }
            if (auth()->user()->hasRole('health_associate')) {
                $query->where('created_by', auth()->user()->id);
            }
        })->with('bankAccountDetails')->with('address')->where(function ($query) use ($filter) {
            if (array_key_exists('name', $filter) && $filter['name'] != '') {
                $query->where('laboratory_name', 'like', '%' . $filter['name'] . '%');
            }
        });

        $list = $list->orderBy('id', 'desc');
        if ($request->filled('report')) {

            $list = $list->get();
            if ($list->count() > 0) {
                $input_to_excel_sheet = array();
                $input_to_excel_sheet[] = array('Pharmacy Id', 'Pharmacy Name', 'Mobile No', 'Email', 'Country', 'State', 'City/Village', 'Date of Approval', 'Status');

                foreach ($list as $key => $user) {
                    $address = array('country' => '', 'state' => '', 'city' => '');
                    if (!is_null($user->address->first())) {
                        $address['country'] = $user->address->first()->country;
                        $address['state'] = $user->address->first()->state;
                        $address['city'] = $user->address->first()->city_village;
                    }
                    $input_to_excel_sheet[] = array(
                        0 => $user->laboratory_unique_id,
                        1 => $user->user->first_name . ' ' . $user->user->middle_name . ' ' . $user->user->last_name,
                        2 => $user->user->country_code . ' ' . $user->user->mobile_number,
                        3 => $user->user->email,
                        4 => $address['country'],
                        5 => $address['state'],
                        6 => $address['city'],
                        7 => $user->user->approved_date,
                        8 => $user->user->is_active == 1 ? 'Active' : 'Inactive',
                    );
                }
                $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
                return response()->download($excel['attach_file_path']);
            }
            return new ErrorMessage("No records found.", 404);
        }
        $list = $list->paginate(LaboratoryInfo::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin list Roles
     *
     * Authorization: "Bearer {access_token}"
     *
     * @response 200 [
     *    {
     *        "id": 2,
     *        "title": "Admin",
     *        "name": "admin",
     *        "unique_id": "RL02",
     *        "guard_name": "web"
     *    },
     *    {
     *        "id": 3,
     *        "title": "Patient",
     *        "name": "patient",
     *        "unique_id": "RL03",
     *        "guard_name": "web"
     *    }
     *]
     *
     */
    public function listRoles()
    {
        $list = Role::whereNotIn('id', [1])->get();
        return response()->json($list, 200);
    }

    /**
     * @authenticated
     *
     * @group Admin
     *
     * Admin list Employee
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[name]='text'
     * @queryParam filter.active nullable filter[active]=1,0,2
     * @queryParam user_type required user_type -> HEALTHASSOCIATE or EMPLOYEE
     * @queryParam report nullable send 1 to download as excel
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 3,
     *            "unique_id": "EMP0000003",
     *            "father_first_name": "dad",
     *            "father_middle_name": "dad midle",
     *            "father_last_name": "dad last",
     *            "date_of_birth": "1995-10-10",
     *            "age": 25,
     *            "date_of_joining": "2020-10-10",
     *            "gender": "MALE",
     *            "user": {
     *                "id": 33,
     *                "first_name": "Employee",
     *                "middle_name": "middle",
     *                "last_name": "last",
     *                "email": "employee@logidots",
     *                "username": "Emp5f9c0972bf270",
     *                "country_code": "+91",
     *                "mobile_number": "9876543288",
     *                "user_type": "EMPLOYEE",
     *                "is_active": "0",
     *                "profile_photo_url": null,
     *                "approved_by": "Jon"
     *            },
     *            "address": [
     *                {
     *                    "id": 75,
     *                    "street_name": "Lane",
     *                    "city_village": "land",
     *                    "district": "CA",
     *                    "state": "KL",
     *                    "country": "IN",
     *                    "pincode": "654321",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/employee?page=1",
     *    "from": 1,
     *    "last_page": 2,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/employee?page=2",
     *    "next_page_url": "http://localhost/fms-api-laravel/public/api/admin/list/employee?page=2",
     *    "path": "http://localhost/fms-api-laravel/public/api/admin/list/employee",
     *    "per_page": 1,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 2
     *}
     *
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "user_type": [
     *            "The selected user type is invalid."
     *        ]
     *    }
     *}
     * @response 404 {
     *     "message": "No records found."
     *}
     */

    public function listEmployee(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.active' => 'nullable|in:0,1,2',
            'user_type' => 'required|in:HEALTHASSOCIATE,EMPLOYEE',
            'report' => 'nullable|in:1',
        ]);

        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }

        $list = Employee::with('user')->whereHas('user', function ($query) use ($filter, $validatedData) {
            $query->where('user_type', $validatedData['user_type']);
            if (array_key_exists('active', $filter) && $filter['active'] != '') {
                $query->where('is_active', $filter['active']);
            }
            if (array_key_exists('name', $filter) && $filter['name'] != '') {

                $query->where('first_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('middle_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('last_name', 'like', '%' . $filter['name'] . '%');
            }
            //$query->where('is_active', '!=', '2');
            if (auth()->user()->hasRole('health_associate')) {
                $query->where('created_by', auth()->user()->id);
            }
        })->with('address')->orderBy('id', 'desc');

        if ($request->filled('report')) {

            $list = $list->get();
            if ($list->count() > 0) {

                $input_to_excel_sheet = array();
                $input_to_excel_sheet[] = array('Employee No', 'Employee Name', 'Mobile No', 'Email', 'Age', 'Role', 'Date of Joining', 'Status', 'City');
                $role = 'Employee';
                if ($validatedData['user_type'] == 'HEALTHASSOCIATE') {
                    $role = 'Health Associate';
                }

                foreach ($list as $key => $user) {
                    $input_to_excel_sheet[] = array(
                        0 => $user->unique_id,
                        1 => $user->user->first_name . ' ' . $user->user->middle_name . ' ' . $user->user->last_name,
                        2 => $user->user->country_code . ' ' . $user->user->mobile_number,
                        3 => $user->user->email,
                        4 => $user->age,
                        5 => $role,
                        6 => $user->date_of_joining,
                        7 => $user->user->is_active == 1 ? 'Active' : 'Inactive',
                        8 => !is_null($user->address->first()) ? $user->address->first()->city_village : 'NA',
                    );
                }
                $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
                return response()->download($excel['attach_file_path']);
            }
            return new ErrorMessage("No records found.", 404);
        }

        $list = $list->paginate(Employee::$page);
        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin, Employee  list Patients
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam filter nullable array filter[name]='text', filter[approved] any one of 0,1,2 filter[approved] = 0 for list to be approved, filter[approved] = 1 for approved list, filter[approved] = 2 for rejected list, filter[city]='text' for filter by city.
     * @queryParam report nullable send 1 to download as excel
     *
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "user_id": 3,
     *            "patient_unique_id": "P0000001",
     *            "title": null,
     *            "gender": null,
     *            "date_of_birth": null,
     *            "age": null,
     *            "blood_group": null,
     *            "height": null,
     *            "weight": null,
     *            "marital_status": null,
     *            "occupation": null,
     *            "alt_country_code": null,
     *            "alt_mobile_number": null,
     *            "current_medication": null,
     *            "bpl_file_number": null,
     *            "bpl_file_name": null,
     *            "national_health_id": null,
     *            "patient_profile_photo": null,
     *            "user": {
     *                "id": 3,
     *                "first_name": "Test",
     *                "middle_name": null,
     *                "last_name": "Patient",
     *                "email": "patient@logidots.com",
     *                "username": "patient",
     *                "country_code": "+91",
     *                "mobile_number": "9876543210",
     *                "user_type": "PATIENT",
     *                "is_active": "1",
     *                "profile_photo_url": null,
     *                "approved_by": "Jon"
     *            },
     *            "address": [
     *                {
     *                    "id": 1,
     *                    "street_name": "North Road",
     *                    "city_village": "BBB",
     *                    "district": "Palakkad",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "627672",
     *                    "country_code": null,
     *                    "contact_number": null,
     *                    "latitude": "10.53034500",
     *                    "longitude": "76.21472900",
     *                    "clinic_name": "quigley"
     *                }
     *            ]
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/administrator/list/patient?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/administrator/list/patient?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/administrator/list/patient",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *     "message": "No records found."
     *}
     */
    public function listPatients(Request $request)
    {
        $validatedData = $request->validate([
            'filter' => 'nullable|array',
            'filter.approved' => 'nullable|in:0,1,2',
            'filter.city' => 'nullable',
            'report' => 'nullable|in:1',
        ]);

        $filter = array();
        if (!empty($validatedData['filter'])) {
            $filter = $validatedData['filter'];
        }

        $list = PatientPersonalInfo::with('user')->whereHas('user', function ($query) use ($filter) {

            if (array_key_exists('approved', $filter) && $filter['approved'] != '') {

                $query->where('is_active', $filter['approved']);
            }
            if (array_key_exists('name', $filter) && $filter['name'] != '') {

                $query->where('first_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('middle_name', 'like', '%' . $filter['name'] . '%');
                $query->orWhere('last_name', 'like', '%' . $filter['name'] . '%');
            }

            if (auth()->user()->hasRole('health_associate')) {
                $query->where('created_by', auth()->user()->id);
            }
        })->with('address');
        if (array_key_exists('city', $filter) && $filter['city'] != '') {

            $list =  $list->whereHas('address', function ($query) use ($filter) {
                $query->where('city_village', 'like', '%' . $filter['city'] . '%');
            });
        }
        $list =  $list->orderBy('id', 'desc');

        if ($request->filled('report')) {

            $list = $list->get();
            if ($list->count() > 0) {
                $input_to_excel_sheet = array();
                $input_to_excel_sheet[] = array('Patient Id', 'Patient Name', 'Age', 'Mobile No', 'Email', 'Country', 'State', 'City/Village', 'Status');

                foreach ($list as $key => $user) {
                    $address = array('country' => '', 'state' => '', 'city' => '');
                    if (!is_null($user->address->first())) {
                        $address['country'] = $user->address->first()->country;
                        $address['state'] = $user->address->first()->state;
                        $address['city'] = $user->address->first()->city_village;
                    }
                    $input_to_excel_sheet[] = array(
                        0 => $user->patient_unique_id,
                        1 => $user->user->first_name . ' ' . $user->user->middle_name . ' ' . $user->user->last_name,
                        2 => $user->age,
                        3 => $user->user->country_code . ' ' . $user->user->mobile_number,
                        4 => $user->user->email,
                        5 => $address['country'],
                        6 => $address['state'],
                        7 => $address['city'],
                        8 => $user->user->is_active == 1 ? 'Active' : 'Inactive',
                    );
                }
                $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
                return response()->download($excel['attach_file_path']);
            }
            return new ErrorMessage("No records found.", 404);
        }

        $list = $list->paginate(PatientPersonalInfo::$page);

        if ($list->count() > 0) {
            return response()->json($list, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }

    /**
     * @authenticated
     *
     * @group Administrator
     *
     * Admin list Appointments
     *
     * Authorization: "Bearer {access_token}"
     *
     * @queryParam start_date nullable date present format-> Y-m-d
     * @queryParam end_date nullable date present format-> Y-m-d
     * @queryParam doctor_id nullable present id of doctor
     * @queryParam status nullable present PNS, Not completed, Completed
     * @queryParam consultation_type nullable present INCLINIC,ONLINE,EMERGENCY
     * @queryParam start_fee nullable present
     * @queryParam end_fee nullable present
     * @queryParam followup nullable present FREE,PAID
     * @queryParam search nullable present
     * @queryParam report nullable present send 1
     * @response 422 {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "start_date": [
     *            "The start date field must be present."
     *        ],
     *        "end_date": [
     *            "The end date field must be present."
     *        ],
     *        "doctor_id": [
     *            "The doctor id field must be present."
     *        ],
     *        "status": [
     *            "The status field must be present."
     *        ],
     *        "consultation_type": [
     *            "The consultation type field must be present."
     *        ],
     *        "start_fee": [
     *            "The start fee field must be present."
     *        ],
     *        "followup": [
     *            "The followup field must be present."
     *        ],
     *        "search": [
     *            "The search field must be present."
     *        ]
     *    }
     *}
     * @response 200 {
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1410,
     *            "doctor_id": 25,
     *            "patient_id": 22,
     *            "appointment_unique_id": "AP0001410",
     *            "date": "2021-06-08",
     *            "time": null,
     *            "consultation_type": "EMERGENCY",
     *            "shift": "NIGHT",
     *            "payment_status": "Paid",
     *            "total": 571.93,
     *            "tax": 0,
     *            "is_cancelled": 0,
     *            "is_completed": 1,
     *            "followup_id": null,
     *            "followup_date": null,
     *            "cancel_time": 2,
     *            "reschedule_time": 2,
     *            "comment": null,
     *            "cancelled_by": null,
     *            "reschedule_by": null,
     *            "booking_date": "2021-06-08",
     *            "current_patient_info": {
     *                "user": {
     *                    "first_name": "Vishnu",
     *                    "middle_name": "S",
     *                    "last_name": "Sharma",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "+91",
     *                    "mobile_number": "3736556464",
     *                    "profile_photo_url": null
     *                },
     *                "case": 0,
     *                "info": {
     *                    "first_name": "Manoj",
     *                    "middle_name": null,
     *                    "last_name": "Tiwari",
     *                    "email": "vishnusharmatest123@yopmail.com",
     *                    "country_code": "in",
     *                    "mobile_number": "8888888882",
     *                    "height": null,
     *                    "weight": null,
     *                    "gender": null,
     *                    "age": null
     *                },
     *                "address": {
     *                    "id": 22,
     *                    "street_name": "ABC street 66",
     *                    "city_village": "new villagehdhdh",
     *                    "district": "Thiruvananthapuram",
     *                    "state": "Kerala",
     *                    "country": "India",
     *                    "pincode": "695017",
     *                    "country_code": null,
     *                    "contact_number": "6644883737",
     *                    "land_mark": "Near temple lane",
     *                    "latitude": null,
     *                    "longitude": null,
     *                    "clinic_name": null
     *                }
     *            },
     *            "doctor": {
     *                "id": 25,
     *                "first_name": "Ravi",
     *                "middle_name": null,
     *                "last_name": "Tharakan",
     *                "email": "ravi.tharakantest@yopmail.com",
     *                "username": "RAVI",
     *                "country_code": "+91",
     *                "mobile_number": "7835516447",
     *                "user_type": "DOCTOR",
     *                "is_active": "1",
     *                "role": [
     *                    4
     *                ],
     *                "currency_code": "INR",
     *                "approved_date": "2021-03-08",
     *                "comment": null,
     *                "profile_photo_url": null
     *            },
     *            "prescription": {
     *                "id": 504,
     *                "appointment_id": 1410,
     *                "pdf_url": null,
     *                "status_medicine": "Requested"
     *            }
     *        }
     *    ],
     *    "first_page_url": "http://localhost/fms-api-laravel/public/api/administrator/list/appointments?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "last_page_url": "http://localhost/fms-api-laravel/public/api/administrator/list/appointments?page=1",
     *    "next_page_url": null,
     *    "path": "http://localhost/fms-api-laravel/public/api/administrator/list/appointments",
     *    "per_page": 10,
     *    "prev_page_url": null,
     *    "to": 1,
     *    "total": 1
     *}
     * @response 404 {
     *     "message": "No records found."
     *}
     */
    public function listAppointments(Request $request)
    {
        $request->validate([
            'start_date' => 'present|nullable|date_format:Y-m-d',
            'end_date' => 'present|nullable|date_format:Y-m-d|required_with:start_date',
            'doctor_id' => 'present|nullable',
            'status' => 'present|nullable|in:PNS,Not completed,Completed',
            'consultation_type' => 'present|nullable|in:INCLINIC,ONLINE,EMERGENCY',
            'start_fee' => 'present|nullable|numeric',
            'end_fee' => 'present|nullable|numeric|required_with:start_fee',
            'followup' => 'present|nullable|in:FREE,PAID',
            'search' => 'present|nullable',
            'report' => 'present|nullable|in:1'
        ]);

        $record = Appointments::with('doctor')->with('doctorinfo')->with('doctorinfo.specialization')->with('clinic_address')->with('prescription')->with(['prescription' => function ($query) {
            $query->select('id', 'appointment_id', 'file_path');
        }]);
        //filter 1
        if ($request->filled('consultation_type')) {
            $record = $record->where('consultation_type', $request->consultation_type);
        }
        //filter 2
        if ($request->filled('status')) {

            if ($request->status == 'PNS') {
                $record = $record->where('comment', $request->status);
            } elseif ($request->status == 'Completed') {
                $record = $record->where('is_completed', 1);
            } else {
                $record = $record->where('is_completed', 0);
            }
        }
        //filter 3
        if ($request->filled('doctor_id')) {

            $record = $record->where('doctor_id', $request->doctor_id);
        }
        //filter 4
        if ($request->filled('start_fee')) {

            $record = $record->whereBetween('total', [$request->start_fee, $request->end_fee]);
        }
        //filter 5
        if ($request->filled('search')) {
            if (strpos($request->search, 'AP') !== false) {
                $record = $record->where('appointment_unique_id', $request->search);
            } else {
                $record = $record->whereHas('clinic_address', function ($query) use ($request) {
                    $query->where('city_village', 'like', '%' . $request->search . '%');
                });
            }
        }
        //filter 6
        if ($request->filled('followup')) {

            if ($request->followup == 'PAID') {
                $record = $record->whereNull('followup_id');
            } else {
                $record = $record->whereNotNull('followup_id');
            }
        }
        //filter 7
        if ($request->filled('start_date')) {
            $record = $record->whereBetween('date', [Carbon::parse($request->start_date)->startOfDay(), Carbon::parse($request->end_date)->endOfDay()]);
        }
        $record = $record->orderBy('id', 'desc');
        //for report generation
        if ($request->filled('report')) {
            $input_to_excel_sheet = array();
            $input_to_excel_sheet[] = array('Appointment Id', 'Doctor Name', 'Patient Name', 'Consultation Mode', 'Booking Date', 'Appointment Date', 'Appointment Time', 'City', 'Doctor’s Fee', 'Commission', 'Tax', 'Total', 'Appointment Status', 'Doctor Status', 'Patient Address');
            $records = $record->get();
            $records->makeVisible('commission');

            foreach ($records as $key => $record) {
                if ($record->consultation_type == 'INCLINIC') {
                    $doctor_fee = $record->doctorinfo->consulting_offline_fee;
                    $appointment_time = Carbon::parse($record->time)->format('h:i A');
                } elseif ($record->consultation_type == 'ONLINE') {
                    $doctor_fee = $record->doctorinfo->consulting_online_fee;
                    $appointment_time = Carbon::parse($record->time)->format('h:i A');
                } else { //EMERGENCY
                    $doctor_fee = $record->doctorinfo->emergency_fee;
                    $appointment_time = 'NA';
                }

                $appointment_status = 'Booked';

                if ($record->is_cancelled == 1) {
                    $appointment_status = 'Cancelled';
                }
                if ($record->is_completed == 1) {
                    $appointment_status = 'Completed';
                }
                $patient_address = 'NA';
                if (!is_null($record->current_patient_info['address'])) {
                    $patient_address = $record->current_patient_info['address']->street_name . ', ' . $record->current_patient_info['address']->city_village . ', ' .
                        $record->current_patient_info['address']->district . ', ' .
                        $record->current_patient_info['address']->state . ', ' . $record->current_patient_info['address']->country . ', ' . $record->current_patient_info['address']->pincode;
                }
                $input_to_excel_sheet[] = array(
                    $record->appointment_unique_id,
                    'Dr. ' . $record->doctor->first_name . ' ' . $record->doctor->middle_name . ' ' . $record->doctor->last_name,
                    $record->current_patient_info['info']['first_name'] . ' ' . $record->current_patient_info['info']['middle_name'] . ' ' . $record->current_patient_info['info']['last_name'],
                    $record->consultation_type,
                    $record->booking_date,
                    $record->date,
                    $appointment_time,
                    $record->clinic_address->city_village,
                    $doctor_fee,
                    $record->commission,
                    $record->tax,
                    $record->total,
                    $appointment_status,
                    $record->comment,
                    $patient_address,
                );
            }

            $excel = (new ImportService)->generateSpreadsheet(NULL, $input_to_excel_sheet);
            return response()->download($excel['attach_file_path']);
        }
        $record = $record->paginate(Appointments::$page);

        if ($record->count() > 0) {
            $record->makeVisible('commission');
            $record->makeHidden(['patient_details', 'patient_more_info', 'start_time', 'end_time',]);
            $result = $record->toArray();
            $datas = $result['data'];
            foreach ($datas as $key => $data) {
                unset($data['prescription']['medicinelist']);
                unset($data['prescription']['testlist']);
                $datas[$key] = $data;
            }
            $result['data'] = $datas;
            return response()->json($result, 200);
        }
        return new ErrorMessage("No records found.", 404);
    }
}
