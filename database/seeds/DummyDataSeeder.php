<?php

use Illuminate\Database\Seeder;
use App\Model\Address;
use App\Model\AdminSettings;
use App\Model\Appointments;
use App\Model\BankAccountDetails;
use App\Model\DoctorClinicDetails;
use App\Model\DoctorPersonalInfo;
use App\Model\DoctorTimeSlots;
use App\Model\Employee;
use App\Model\Followups;
use App\Model\LaboratoryInfo;
use App\Model\PatientPersonalInfo;
use App\Model\Pharmacy;
use App\User;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSettings::firstOrCreate(['option' => 'cancel_time_period'], ['value' => 48]);
        AdminSettings::firstOrCreate(['option' => 'reschedule_time_period'], ['value' => 48]);

        return;
        $listpatient = User::where('user_type', 'PATIENT')->doesntHave('patient')->pluck('id');
        $listpatient = $listpatient->toArray();

        foreach ($listpatient as $key => $patient) {
            $data['user_id'] = $patient;
            $data['patient_unique_id'] = getPatientId();
            PatientPersonalInfo::create($data);
            $user = User::find($patient);
            $user->assignRole('patient');
        }

        $admin = User::where("email", "superadmin@logidots.com")->first();
        $admin->assignRole('super_admin');

        $addressData = array(
            array(
                'pincode' => '686575',
                'street_name' => 'South Road',
                'city_village' => 'Edamattom',
                'district' => 'Kottayam',
                'state' => 'Kerala',
                'country' => 'India',
                'latitude' => '10.530345',
                'longitude' => '76.214729',
                'address_type' => 'CLINIC',
            ),
            array(
                'pincode' => '691307',
                'street_name' => 'East Road',
                'city_village' => 'Edamon',
                'district' => 'Kollam',
                'state' => 'Kerala',
                'country' => 'India',
                'latitude' => '10.530345',
                'longitude' => '76.214729',
                'address_type' => 'CLINIC',
            ),
        );
        $timeSlotData = array(
            array(
                'day' => 'MONDAY',
                'slot_start' => '09:30',
                'slot_end' => '10:30',
                'type' => 'ONLINE',
                'shift' => 'MORNING',
            ),
            array(
                'day' => 'MONDAY',
                'slot_start' => '10:30',
                'slot_end' => '10:45',
                'type' => 'OFFLINE',
                'shift' => 'MORNING',
            )
        );

        $faker = \Faker\Factory::create();

        $list = User::where('user_type', 'DOCTOR')->whereIn("email", [
            'theophilus@logidots.com',
        ])->pluck('id');
        $users = $list->toArray();
        foreach ($users as $key => $user) {
            $temp = User::find($user);
            $temp->assignRole('doctor');

            BankAccountDetails::firstOrCreate(['user_id' => $user], []);
            $qualification  = array('MBBS', 'BDS', 'ENT', 'BHMS', 'MD', 'MS');

            $degree = $qualification[array_rand($qualification)];
            // for doctor_personal_infos table
            $doctorData['doctor_unique_id'] = getDoctorId();

            $doctorData['date_of_birth'] = Carbon::parse(now())->format('Y-m-d');
            $doctorData['age'] = $faker->randomDigitNotNull;

            $doctorData['qualification'] = $degree;
            $doctorData['years_of_experience'] = $faker->randomDigitNotNull;
            $doctorData['alt_mobile_number'] = $faker->phoneNumber;
            $doctorData['user_id'] = $user;
            $doctorData['consulting_offline_fee'] = rand(100, 1000);
            $doctorData['consulting_online_fee'] = rand(100, 1000);
            $doctorData['cancel_time_period'] = 12;
            $doctorData['no_of_followup'] = 2;
            $doctorData['followups_after'] = 1;
            $doctorData['reschedule_time_period'] = 24;

            if ($key > 12) {
                $doctorData['gender'] = 'FEMALE';
            }

            $doctorNew = DoctorPersonalInfo::updateOrCreate([
                'user_id' => $user
            ], $doctorData);

            if ($doctorNew->specialization()->count() === 0) {
                $numbers = [];
                for ($j = 0; $j < 4; $j++) {
                    $numbers[] = rand(1, 8);
                }
                $doctorNew->specialization()->sync(array_unique($numbers));
            }

            foreach ($addressData as $key1 => $data) {
                $data['user_id'] = $user;
                $data['clinic_name'] = $faker->domainWord;
                $address = Address::firstOrCreate([
                    'user_id' => $user
                ], $data);
                $doctorClinicDetails = DoctorClinicDetails::firstOrCreate(
                    ['address_id' => $address->id],
                    []
                );

                if ($address->timeslot()->count() === 0) {
                    foreach ($timeSlotData as $key2 => $timeSlot) {
                        $timeSlot['user_id'] = $user;
                        $timeSlot['doctor_clinic_id'] = $doctorClinicDetails->id;
                        DoctorTimeSlots::create($timeSlot);
                    }
                }
            }
        }

        $faker = \Faker\Factory::create();
        $userData = [
            'first_name' => $faker->name,
            'middle_name' => $faker->name,
            'last_name' => $faker->name,
            'email' => 'labortory@logidots.com',
            'password' => bcrypt('secret'),
            'username' => 'laboratory',
            'user_type' => 'LABORATORY',
            'is_active' => '1',
            'country_code' => '+91',
            'mobile_number' => $faker->phoneNumber,
            'email_verified_at' => now(),
            'mobile_number_verified_at' => now(),
            'approved' => 1,
            'approved_date' => now(),
        ];
        $user = User::firstOrCreate([
            'email' => 'labortory@logidots.com'
        ], $userData);
        $user->assignRole('laboratory');

        LaboratoryInfo::firstOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'laboratory_unique_id' => getLaboratoryId(),
                'laboratory_name' => 'Laboratory Name',
                'gstin' => 'GSTN49598E4',
                'lab_reg_number' => 'LAB12345',
                'lab_issuing_authority' => 'AIMS',
                'lab_date_of_issue' => '2020-10-15',
                'lab_valid_upto' => '2030-10-15',
                'lab_tests' => array(0 => ['id' => 1, 'sample_collect' => 1]),
            ]
        );
        Address::firstOrCreate(['user_id' => $user->id], [
            'pincode' => '691307',
            'street_name' => 'East Road',
            'city_village' => 'Edamon',
            'district' => 'Kollam',
            'state' => 'Kerala',
            'country' => 'India',
            'latitude' => '10.530345',
            'longitude' => '76.214729',
            'address_type' => 'LABORATORY',
        ]);
        BankAccountDetails::firstOrCreate(['user_id' => $user->id], [
            'user_id' => $user->id,
            'bank_account_number' => 'BANK12345',
            'bank_account_holder' => 'BANKER',
            'bank_name' => 'BANK',
            'bank_city' => 'India',
            'bank_ifsc' => 'IFSC45098',
            'bank_account_type' => 'SAVINGS',
        ]);

        $faker = \Faker\Factory::create();
        $userData = [
            'first_name' => $faker->name,
            'middle_name' => $faker->name,
            'last_name' => $faker->name,
            'password' => bcrypt('secret'),
            'username' => 'pharmacy',
            'user_type' => 'PHARMACIST',
            'is_active' => '1',
            'country_code' => '+91',
            'mobile_number' => $faker->phoneNumber,
            'email_verified_at' => now(),
            'mobile_number_verified_at' => now(),
            'approved' => 1,
            'approved_date' => now(),
        ];

        $user = User::firstOrCreate(['email' => 'pharmacy@logidots.com'], $userData);
        $user->assignRole('pharmacist');
        Pharmacy::firstOrCreate(
            ['user_id' => $user->id],
            [
                'pharmacy_unique_id' => getPharmacyId(),
                'pharmacy_name' => 'Pharmacy Name',
                'pharmacist_name' => $userData['last_name'],
                'gstin' => 'GSTN49598E4',
                'dl_number' => 'LAB12345',
                'dl_issuing_authority' => 'AIMS',
                'dl_date_of_issue' => '2020-10-15',
                'dl_valid_upto' => '2030-10-15',
                'dl_file_path' => '/',
                'course' => 'Bsc',
                'pharmacist_reg_number' => 'PHAR1234',
                'issuing_authority' => 'GOVT',
                'reg_certificate_path' => '/',
                'reg_date' => '2020-10-15',
                'reg_valid_upto' => '2030-10-15',
                'order_amount' => 300
            ]
        );
        Address::firstOrCreate(['user_id' => $user->id], [
            'pincode' => '691307',
            'street_name' => 'East Road',
            'city_village' => 'Edamon',
            'district' => 'Kollam',
            'state' => 'Kerala',
            'country' => 'India',
            'latitude' => '10.530345',
            'longitude' => '76.214729',
            'address_type' => 'PHARMACY',
        ]);
        BankAccountDetails::firstOrCreate(['user_id' => $user->id], [
            'bank_account_number' => 'BANK12345',
            'bank_account_holder' => 'BANKER',
            'bank_name' => 'BANK',
            'bank_city' => 'India',
            'bank_ifsc' => 'IFSC45098',
            'bank_account_type' => 'SAVINGS',
        ]);

        $employeeUser = User::where("email", "employee@logidots.com")->first();

        Employee::firstOrCreate(['user_id' => $employeeUser->id], [
            'unique_id' => getEmployeeId(),
            'father_first_name' => 'Dad F',
            'father_middle_name' => 'Dad M',
            'father_last_name' => 'Dad L',
            'gender' => 'MALE',
            'date_of_birth' => '1995-10-15',
            'age' => '25',
            'date_of_joining' => '2020-10-15',
        ]);
        $employeeUser->assignRole('employee');
    }
}
