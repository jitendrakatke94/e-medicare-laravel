<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'guest'], function () {

    //to check scheduler
    Route::get('makepdf', 'API\CommandController@makePdf');

    Route::get('search/address', 'API\SearchController@getAddressList');
    Route::get('search/specialization', 'API\SearchController@getSpecializations');
    Route::get('search/doctor', 'API\SearchController@doctorList');

    Route::get('search/doctor/{id}', 'API\SearchController@getDoctorById');
    Route::get('search/doctor/{id}/overview', 'API\SearchController@getDoctorOverview');
    Route::get('search/doctor/{id}/location', 'API\SearchController@getDoctorLocation');
    Route::get('search/doctor/{id}/review', 'API\SearchController@getDoctorReviews');
    Route::get('search/doctor/{id}/businesshours', 'API\SearchController@getDoctorBusinessHours');

    Route::get('category', 'API\Admin\CategoryController@index');

    Route::get('search/doctor/{id}/schedule', 'API\SearchController@getDoctorAvailableTimeslots');

    Route::get('labtest', 'API\Admin\LabTestController@index');
    Route::get('search/labtest', 'API\Admin\LabTestController@search');
});
# No auth required.
Route::get('search/medicine', 'API\Admin\MedicineController@search');
Route::get('medicine/{id}', 'API\Admin\MedicineController@getMedicineById');

# cart
Route::get('cart/{id}', 'API\CartController@getCartById');
Route::post('cart/create', 'API\CartController@createCart')->name('cart.create');
Route::post('cart/items', 'API\CartController@createCartWithSingleproduct')->name('cart.add.product.single');
Route::post('cart/{id}/items', 'API\CartController@addProductToCart')->name('cart.add.product');
Route::post('cart/{id}/items/update', 'API\CartController@updateProductToCart')->name('cart.update.product');
Route::delete('cart/{id}/items/{cart_item_id}', 'API\CartController@deleteProductFromCart');
Route::delete('cart/{id}', 'API\CartController@deleteCartById');

Route::post('facebook/deletioncallback', 'API\FaceBookController@deletionCallback');
Route::get('facebook/deletionconfirm', 'API\FaceBookController@deletionConfirm');


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('me', 'API\UserController@me');
    Route::get('pdf/download', 'API\PrescriptionsController@download');
    Route::get('search/pharmacy', 'API\ServiceController@search')->name('search.pharmacy');
    Route::get('search/laboratory', 'API\ServiceController@search');
    Route::post('profile/photo', 'API\ServiceController@addProfilePhoto');
    Route::get('geocoding', 'API\ServiceController@geocoding');
    Route::get('reversegeocoding', 'API\ServiceController@reverseGeocoding');
    Route::post('address/validate', 'API\ServiceController@validateAddress');


    Route::get('list/doctor', 'API\ServiceController@listDoctor');

    Route::get('tax', 'API\Admin\TaxController@index');
    Route::get('taxservice', 'API\Admin\TaxServiceController@index');
    Route::get('taxservice/commission', 'API\Admin\TaxServiceController@commisionList');

    //auth user send,verify new mobile and email
    Route::post('checkunique', 'API\UserController@checkUnique');
    Route::post('otp/send', 'API\UserController@authUserSendOTP');
    Route::post('otp/verify', 'API\UserController@authUserVerifyOTP');

    //sales
    Route::get('sales', 'API\SalesController@list');
    Route::get('sales/recent', 'API\SalesController@listRecentTransaction');
    Route::get('sales/chart', 'API\SalesController@getChartData');

    Route::group(['middleware' => ['role:doctor|pharmacist|laboratory']], function () {
        Route::get('payout/user', 'API\PayoutController@listUserPayout');
        Route::get('payout/user/record', 'API\PayoutController@listUserPayoutById');
    });

    Route::get('payout', 'API\PayoutController@list');
    //Route::get('payout/{id}', 'API\PayoutController@getPayoutById');

    Route::get('payout/recent', 'API\PayoutController@listRecentTransaction');
    Route::get('payout/payment/', 'API\PayoutController@getPayoutHistory');
    Route::post('payout/payment/single', 'API\PayoutController@makeSinglePayout');
    Route::post('payout/payment/bulk', 'API\PayoutController@makeBulkPayout');

    # orders
    Route::post('orders/checkout', 'API\OrderController@checkOutOrder')->name('order.checkout');
    Route::post('orders/confirmpayment', 'API\OrderController@confirmPayment')->name('order.confirm');
    Route::get('orders', 'API\OrderController@getOrderList');
    Route::get('orders/{id}', 'API\OrderController@getOrderById');
    Route::post('orders/{id}', 'API\OrderController@editOrder')->middleware('role:pharmacist|laboratory');
    Route::post('orders/cancel', 'API\OrderController@cancelOrder')->middleware('role:patient');
    #Ecommerce
    Route::post('ecommerce/checkout', 'API\EcommerceController@checkOutOrder')->name('ecommerce.checkout');

    //medicine , test depense request update
    Route::post('depense/request/update', 'API\QuoteController@updateDespenseRequest')->middleware('role:pharmacist|laboratory');

    #comment CommentsController
    Route::post('comments', 'API\CommentsController@create')->name('comment.create');
    Route::get('comments', 'API\CommentsController@index');
    Route::delete('comments/{id}', 'API\CommentsController@destroy');

    Route::post('change/username', 'API\UserController@changeUserName');
});

Route::get('admin/specialization', 'API\Admin\SpecializationController@index');

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin|employee|health_associate', 'auth:api']], function () {

    Route::get('specialization/{id}', 'API\Admin\SpecializationController@show');
    Route::post('specialization', 'API\Admin\SpecializationController@store');
    Route::post('specialization/{id}', 'API\Admin\SpecializationController@update');
    Route::delete('specialization/{id}', 'API\Admin\SpecializationController@destroy');

    Route::get('user/commission', 'API\UserCommissionsController@index');
    Route::get('user/commission/{id}', 'API\UserCommissionsController@show');
    Route::post('user/commission', 'API\UserCommissionsController@update');

    Route::get('tax/{id}', 'API\Admin\TaxController@show');
    Route::post('tax', 'API\Admin\TaxController@store');
    Route::post('tax/{id}', 'API\Admin\TaxController@update');
    Route::delete('tax/{id}', 'API\Admin\TaxController@destroy');

    //for now no need for this api
    //Route::post('taxservice', 'API\Admin\TaxServiceController@store')->name('taxservice.add');

    Route::post('taxservice/{id}', 'API\Admin\TaxServiceController@update')->name('taxservice.edit');
    Route::post('taxservice/{id}/commission', 'API\Admin\TaxServiceController@commisionUpdate')->name('commission.edit');

    Route::post('labtest', 'API\Admin\LabTestController@store');
    Route::post('labtest/{id}', 'API\Admin\LabTestController@update');
    Route::delete('labtest/{id}', 'API\Admin\LabTestController@destroy');
    Route::get('labtest/{id}', 'API\Admin\LabTestController@show');

    Route::get('list/roles', 'API\Administrator\ListController@listRoles');
    Route::get('list/employee', 'API\Administrator\ListController@listEmployee');

    Route::post('action/approveorreject', 'API\Admin\ActionsController@approveOrReject');
    Route::post('action/activate', 'API\Admin\ActionsController@activateUser');

    Route::post('laboratory/basicinfo/{id}', 'API\Admin\EditController@laboratoryBasicInfo')->name('laboratoryBasicInfo');
    Route::post('laboratory/address/{id}', 'API\Admin\EditController@laboratoryAddress')->name('laboratoryAddress');
    Route::post('laboratory/testlist/{id}', 'API\Admin\EditController@laboratoryAddTestList')->name('laboratoryAddTestList');
    Route::post('laboratory/bankdetails/{id}', 'API\Admin\EditController@laboratoryAddBankDetails')->name('laboratoryAddBankDetails');

    Route::post('pharmacy/basicinfo/{id}', 'API\Admin\EditController@pharmacyBasicInfo')->name('pharmacyBasicInfo');
    Route::post('pharmacy/address/{id}', 'API\Admin\EditController@pharmacyAddress')->name('pharmacyAddress');
    Route::post('pharmacy/additionaldetails/{id}', 'API\Admin\EditController@pharmacyAdditionaldetails')->name('pharmacyAdditionaldetails');


    Route::get('doctor/profile/{id}', 'API\Admin\EditController@getDoctorProfile');
    Route::post('doctor/profile/{id}', 'API\Admin\EditController@editProfile')->name('doctorEditProfile');
    Route::get('doctor/address/{id}', 'API\Admin\EditController@listDoctorAddress')->name('listDoctorAddress');
    Route::post('doctor/address/{id}', 'API\Admin\EditController@editDoctorAddress')->name('editDoctorAddress');
    Route::get('doctor/additionalinformation/{id}', 'API\Admin\EditController@getAdditionalInformation')->name('getAdditionalInformation');
    Route::post('doctor/additionalinformation/{id}', 'API\Admin\EditController@editAdditionalInformation')->name('editAdditionalInformation');

    Route::get('doctor/bankdetails/{id}', 'API\Admin\EditController@getBankDetails')->name('getBankDetails');
    Route::post('doctor/bankdetails/{id}', 'API\Admin\EditController@addBankDetails')->name('addBankDetails');

    Route::post('employee/basicinfo', 'API\Admin\EmployeeController@employeeBasicInfo')->name('employeeBasicInfo');
    Route::post('employee/basicinfo/{id}', 'API\Admin\EmployeeController@editEmployeeBasicInfo')->name('editEmployeeBasicInfo');
    Route::post('employee/address', 'API\Admin\EmployeeController@employeeAddress')->name('employeeAddress');
    Route::post('employee/address/{id}', 'API\Admin\EmployeeController@editEmployeeAddress')->name('editEmployeeAddress');

    Route::get('employee/{id}', 'API\Admin\EmployeeController@getEmployeeProfile');
    Route::delete('employee/{id}', 'API\Admin\EmployeeController@deactivateEmployee');

    Route::get('patient/profile/{id}', 'API\Admin\EditController@getPatientProfile');
    Route::post('patient/profile/{id}', 'API\Admin\EditController@editPatientProfile')->name('editPatientProfile');
    Route::get('patient/address/{id}', 'API\Admin\EditController@listPatientAddress');
    Route::post('patient/address/{id}', 'API\Admin\EditController@editpatientAddress')->name('admin.patient.address.edit');
    Route::get('patient/family/{id}', 'API\Admin\EditController@listPatientFamilyMember');
    Route::post('patient/family/{id}', 'API\Admin\EditController@editPatientFamilyMember')->name('admin.patient.family.edit');
    Route::post('patient/emergency/{id}', 'API\Admin\EditController@addPatientEmergencyContact')->name('admin.patient.emergency');
    Route::get('patient/emergency/{id}', 'API\Admin\EditController@getPatientEmergencyContact');

    Route::get('patient/bplfile/{id}', 'API\Admin\EditController@getFile');

    Route::post('category', 'API\Admin\CategoryController@store')->name('category.store');
    Route::post('category/{id}', 'API\Admin\CategoryController@update')->name('category.update');
    Route::delete('category/{id}', 'API\Admin\CategoryController@delete');
    Route::get('category/search', 'API\Admin\CategoryController@search');

    Route::post('medicine', 'API\Admin\MedicineController@store')->name('medicine.store');
    Route::get('medicine', 'API\Admin\MedicineController@index');
    Route::post('medicine/{id}', 'API\Admin\MedicineController@update')->name('medicine.update');
    Route::delete('medicine/{id}', 'API\Admin\MedicineController@delete');
});
// routes for admin and employee
Route::group(['prefix' => 'administrator', 'middleware' => ['role:super_admin|admin|employee|doctor|health_associate', 'auth:api']], function () {

    Route::get('list/doctor', 'API\Administrator\ListController@listDoctor');
    Route::get('list/pharmacy', 'API\Administrator\ListController@listPharmacy');
    Route::get('list/laboratory', 'API\Administrator\ListController@listLaboratory');
    Route::get('list/patient', 'API\Administrator\ListController@listPatients');
    Route::get('list/appointments', 'API\Administrator\ListController@listAppointments');

    Route::group(['middleware' => ['role:super_admin|admin|employee|health_associate']], function () {
        Route::post('patient', 'API\Administrator\AdministratorController@addPatient')->name('administrator.add.patient');
        Route::post('doctor', 'API\Administrator\AdministratorController@addDoctor')->name('administrator.add.doctor');
        Route::post('pharmacy', 'API\Administrator\AdministratorController@addPharmacy')->name('administrator.add.pharmacy');
        Route::post('laboratory', 'API\Administrator\AdministratorController@addLaboratory')->name('administrator.add.laboratory');

        Route::post('appointments/updatepns', 'API\Administrator\AdministratorController@updatePNS');
    });
});

Route::group(['prefix' => 'employee', 'middleware' => ['role:employee|super_admin|admin', 'auth:api']], function () {
    Route::get('profile', 'API\EmployeeController@getEmployeeProfile');
});

Route::group(['prefix' => 'test', 'middleware' => ['role:super_admin|admin', 'auth:api']], function () {
    Route::get('config', 'TestController@getAllConfig');
    Route::get('sendmail', 'TestController@sendMail');
    Route::get('seed/medicine', 'TestController@medicineTableSeeding');
    Route::get('haconvert', 'TestController@healthAssociateIdConversion');
});

Route::group(['prefix' => 'healthassociate', 'middleware' => ['role:health_associate', 'auth:api']], function () {
    Route::get('profile', 'API\HealthAssociateController@getProfile');
    Route::post('profile', 'API\HealthAssociateController@editProfile')->name('edit.health.profile');
    Route::post('address', 'API\HealthAssociateController@editAddress')->name('edit.health.address');
});

Route::group(['prefix' => 'pharmacy', 'middleware' => ['role:pharmacist', 'auth:api']], function () {
    Route::get('profile', 'API\PharmacyController@getProfile');
    Route::post('profile', 'API\PharmacyController@editProfile');

    Route::get('quote/request', 'API\QuoteController@getQuoteRequestPharmacy');
    Route::get('quote/request/{id}', 'API\QuoteController@getQuoteRequestPharmacyById');

    Route::post('quote/request', 'API\QuoteController@editQuoteRequestPharmacyById');

    Route::post('quote', 'API\QuoteController@addQuotePharmacy')->name('add.quote.pharmacy');
    Route::get('quote/{id}/request', 'API\QuoteController@getPharmacyAddedQuoteByRequestId');

    Route::get('quote', 'API\QuoteController@getQuotePharmacy');
    Route::get('quote/{id}', 'API\QuoteController@getQuotePharmacyById');

    Route::get('payouts', 'API\PharmacyController@listPayouts');
});

Route::group(['prefix' => 'laboratory', 'middleware' => ['role:laboratory', 'auth:api']], function () {
    Route::get('profile', 'API\LaboratoryController@getProfile');
    Route::post('profile', 'API\LaboratoryController@editProfile')->name('laboratory.profile');

    Route::get('test', 'API\LaboratoryController@getLaboratoryTest');
    Route::post('test', 'API\LaboratoryController@addLaboratoryTest')->name('laboratory.add.test');

    Route::get('quote/request', 'API\QuoteController@getQuoteRequestLaboratory');
    Route::get('quote/request/{id}', 'API\QuoteController@getQuoteRequestLaboratoryById');

    Route::post('quote/request', 'API\QuoteController@editQuoteRequestLaboratoryById');


    Route::post('quote', 'API\QuoteController@addQuoteLaboratory')->name('add.quote.laboratory');
    Route::get('quote/{id}/request', 'API\QuoteController@getLaboratoryAddedQuoteByRequestId');

    Route::get('quote', 'API\QuoteController@getQuoteLaboratory');
    Route::get('quote/{id}', 'API\QuoteController@getQuoteLaboratoryById');

    Route::get('payouts', 'API\LaboratoryController@listPayouts');
});

Route::group(['prefix' => 'oauth'], function () {
    Route::post('register', 'API\UserController@register');

    Route::post('otp/resend/email', 'API\UserController@ResendEmailOTP');
    Route::post('otp/resend/mobile', 'API\UserController@resendMobileOTP');
    Route::post('otp/verify/mobile', 'API\UserController@verifyMobileOTP');
    Route::post('otp/verify/email', 'API\UserController@verifyEmailOTP');
    Route::post('otp/verify/mobileandemail', 'API\UserController@verifyEmailandMobileOTP');

    Route::post('login', 'API\AuthController@login');
    Route::post('refresh', 'API\AuthController@getAccessTokenUsingRefreshToken');
    Route::get('logout', 'API\AuthController@logout')->middleware('auth:api');

    Route::post('password/forgot', 'API\UserController@forgotPassword');
    Route::post('password/forgot/verify', 'API\UserController@forgotPasswordVerify');
    Route::post('password/change', 'API\UserController@changePassword')->middleware('auth:api');

    Route::get('check/username', 'API\UserController@checkUserName');
});

//appointments
Route::group(['prefix' => 'appointments'], function () {
    Route::post('details', 'API\AppointmentsController@getDetailsForAppointment')->name('appointments.details');
    Route::get('prescription', 'API\PrescriptionsController@listPrescription')->middleware('auth:api');

    Route::group(['middleware' => ['role:patient', 'auth:api']], function () {
        Route::get('continue/{id}', 'API\AppointmentsController@continueWithAppointment');
        Route::post('confirm', 'API\AppointmentsController@confirmAppointment')->name('appointments.confirm');
        Route::post('checkout', 'API\OrderController@appointmentCheckOut')->name('appointments.checkout');
        Route::post('confirmpayment', 'API\OrderController@appointmentConfirmPayment')->name('appointments.confirmpayment');
        Route::post('cancelpayment', 'API\OrderController@appointmentCancelPayment');
    });
});

Route::group(['prefix' => 'patient', 'middleware' => ['role:patient', 'auth:api']], function () {

    Route::get('profile', 'API\PatientController@getProfile');
    Route::post('profile', 'API\PatientController@editProfile')->name('patient.profile.edit');

    Route::post('contact/emergency', 'API\PatientController@addEmergencyContact')->name('patient.contact.emergency');
    Route::get('contact/emergency', 'API\PatientController@getEmergencyContact');

    Route::get('profile/bplfile', 'API\PatientController@getFile');

    Route::post('address', 'API\PatientController@addAddress')->name('patient.address.add');
    Route::post('address/{id}', 'API\PatientController@editAddress')->name('patient.address.edit');
    Route::get('address', 'API\PatientController@listAddress')->name('patient.address.list');
    Route::get('address/{id}', 'API\PatientController@getAddressById');
    Route::delete('address/{id}', 'API\PatientController@deleteAddress');

    Route::post('family', 'API\PatientController@addFamilyMember')->name('patient.family.add');
    Route::post('family/{id}', 'API\PatientController@editFamilyMember')->name('patient.family.edit');
    Route::get('family', 'API\PatientController@listFamilyMember')->name('patient.family.list');
    Route::get('family/{id}', 'API\PatientController@getFamilyMemberById');
    Route::delete('family/{id}', 'API\PatientController@deleteFamilyMember');

    Route::post('review', 'API\PatientReviewsController@store')->name('patient.review.add');
    Route::post('review/{id}', 'API\PatientReviewsController@update')->name('patient.review.edit');
    Route::get('review', 'API\PatientReviewsController@index');
    Route::get('review/{id}', 'API\PatientReviewsController@show');
    Route::delete('review/{id}', 'API\PatientReviewsController@destroy');

    Route::get('appointments', 'API\PatientController@listAppointments');
    Route::get('appointments/{id}', 'API\PatientController@listAppointmentsById');
    Route::get('appointments/cancel/{id}', 'API\PatientController@cancelAppointments');
    Route::post('appointments/reschedule', 'API\PatientController@rescheduleAppointments');

    Route::get('followups', 'API\PatientController@listFollowups');
    Route::post('followups/cancel/{id}', 'API\PatientController@cancelFollowup');
    //Route::get('followups/timeslots/{id}', 'API\PatientController@getFollowupTimeslots');

    Route::get('prescription', 'API\PatientController@listPrescription');
    Route::get('prescription/medicine', 'API\PatientController@listMedicine');
    Route::get('prescription/test', 'API\PatientController@listTest');

    Route::get('prescription/test', 'API\PatientController@listTest');
    Route::post('sendquote/pharmacy', 'API\QuoteController@sendQuoteRequestPharmacy')->name('patient.quote.request.pharmacy');
    Route::post('sendquote/laboratory', 'API\QuoteController@sendQuoteRequestLaboratory')->name('patient.quote.request.laboratory');

    Route::get('quote', 'API\QuoteController@getPatientQuoteList');
    Route::get('quote/{id}', 'API\QuoteController@getPatientQuoteById');
    Route::delete('quote/{id}', 'API\QuoteController@deleteQuote');

    Route::get('orders', 'API\OrderController@patientGetOrderList');
    Route::get('orders/{id}', 'API\OrderController@patientGetOrderById');
});

Route::group(['prefix' => 'doctor', 'middleware' => ['role:super_admin|doctor', 'auth:api']], function () {

    Route::post('appointments/cancel/{id}', 'API\DoctorController@cancelAppointments');
    Route::post('appointments/reschedule', 'API\DoctorController@rescheduleAppointments');
});

Route::group(['prefix' => 'doctor', 'middleware' => ['role:doctor', 'auth:api']], function () {

    Route::get('profile', 'API\DoctorController@getProfile');
    Route::post('profile', 'API\DoctorController@editProfile')->name('doctor.profile.edit');

    Route::get('profile/additionalinformation', 'API\DoctorController@getAdditionalInformation');
    Route::post('profile/additionalinformation', 'API\DoctorController@editAdditionalInformation')->name('doctor.profile.additionalinformation');

    Route::post('bankdetails', 'API\DoctorController@addBankDetails')->name('doctor.bankdetails');
    Route::get('bankdetails', 'API\DoctorController@getBankDetails');

    Route::post('address', 'API\DoctorController@addAddress')->name('doctor.address.add');
    Route::post('address/{id}', 'API\DoctorController@editAddress')->name('doctor.address.edit');
    Route::get('address', 'API\DoctorController@listAddress')->name('doctor.address.list');
    Route::get('address/{id}', 'API\DoctorController@getAddressById');
    Route::delete('address/{id}', 'API\DoctorController@deleteAddress');
    Route::get('address/{id}/check', 'API\DoctorController@checkAddressHasTimeslots');

    Route::get('timeslot', 'API\DoctorTimeSlotController@index');
    Route::get('timeslot/{id}', 'API\DoctorTimeSlotController@show');
    Route::post('timeslot', 'API\DoctorTimeSlotController@store')->name('doctor.timeslot.add');;
    Route::delete('timeslot/{id}', 'API\DoctorTimeSlotController@destroy');

    Route::post('validate/timeslot', 'API\DoctorOffDaysController@validateTimeSlot')->name('validate.timeslot');
    Route::post('schedule/offdays', 'API\DoctorOffDaysController@scheduleOffdays')->name('schedule.offdays');
    Route::get('schedule/offdays', 'API\DoctorOffDaysController@getOffdays');
    Route::delete('schedule/offdays/{id}', 'API\DoctorOffDaysController@destroy');

    Route::get('appointments', 'API\DoctorController@listAppointments');
    Route::get('appointments/{id}', 'API\DoctorController@listAppointmentsById');

    Route::post('appointments/complete', 'API\DoctorController@completeAppointment');


    Route::get('patient/profile/{id}', 'API\DoctorController@getPatientProfile');

    Route::get('patient/socialhistory', 'API\PatientHistoryController@getPatientSocialHistory');
    Route::get('patient/familyhistory', 'API\PatientHistoryController@getPatientFamilyHistory');
    Route::get('patient/allergicdetails', 'API\PatientHistoryController@getPatientAllergicDetails');

    Route::post('patient/socialhistory', 'API\PatientHistoryController@addPatientSocialHistory');
    Route::post('patient/familyhistory', 'API\PatientHistoryController@addPatientFamilyHistory');
    Route::post('patient/allergicdetails', 'API\PatientHistoryController@addPatientAllergicDetails');

    Route::post('prescription', 'API\PrescriptionsController@addPrescription')->name('add.prescription');

    Route::get('associated/pharmacy', 'API\DoctorController@associatedPharmacy');
    Route::get('associated/laboratory', 'API\DoctorController@associatedLaboratory');

    Route::get('payouts', 'API\DoctorController@listPayouts');

    Route::get('workinghours', 'API\DoctorWorkingHoursController@index');
    Route::post('workinghours', 'API\DoctorWorkingHoursController@store');
});

Route::group(['prefix' => 'oauth/pharmacy'], function () {

    Route::post('basicinfo', 'API\PharmacyRegistrationController@basicInfo')->name('pharmacy.basicinfo');
    Route::post('address', 'API\PharmacyRegistrationController@address')->name('pharmacy.address');
    Route::post('additionaldetails', 'API\PharmacyRegistrationController@additionalDetails')->name('pharmacy.additionaldetails');

    Route::post('otp/resend/email', 'API\PharmacyRegistrationController@ResendEmailOTP');
    Route::post('otp/resend/mobile', 'API\PharmacyRegistrationController@resendMobileOTP');
    Route::post('otp/verify/mobileandemail', 'API\PharmacyRegistrationController@verifyEmailandMobileOTP');
});

Route::group(['prefix' => 'oauth/laboratory'], function () {

    Route::post('basicinfo', 'API\LaboratoryRegistrationController@basicInfo')->name('laboratory.basicinfo');
    Route::post('address', 'API\LaboratoryRegistrationController@address')->name('laboratory.address');
    Route::post('testlist', 'API\LaboratoryRegistrationController@addTestList')->name('laboratory.testlist');
    Route::post('bankdetails', 'API\LaboratoryRegistrationController@addBankDetails')->name('laboratory.bankdetails');

    Route::post('otp/resend/email', 'API\LaboratoryRegistrationController@ResendEmailOTP');
    Route::post('otp/resend/mobile', 'API\LaboratoryRegistrationController@resendMobileOTP');
    Route::post('otp/verify/mobileandemail', 'API\LaboratoryRegistrationController@verifyEmailandMobileOTP');
});

Route::group(['prefix' => 'oauth/healthassociate'], function () {
    Route::post('basicinfo', 'API\HealthAssociateRegistrationController@basicInfo')->name('health.basicinfo');
    Route::post('address', 'API\HealthAssociateRegistrationController@address')->name('health.address');

    Route::post('otp/resend/email', 'API\HealthAssociateRegistrationController@ResendEmailOTP');
    Route::post('otp/resend/mobile', 'API\HealthAssociateRegistrationController@resendMobileOTP');
    Route::post('otp/verify/mobileandemail', 'API\HealthAssociateRegistrationController@verifyEmailandMobileOTP');
});

Route::group(['prefix' => 'oauth/ecommerce'], function () {
    Route::post('register', 'API\UserController@registerEcommerce')->name('ecommerce.register');
});
