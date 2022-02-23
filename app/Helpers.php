<?php

use App\Model\QuoteRequest;
use App\Model\Appointments;
use App\Model\DoctorPersonalInfo;
use App\Model\Employee;
use App\Model\LaboratoryInfo;
use App\Model\LabTest;
use App\Model\Medicine;
use App\Model\Orders;
use App\Model\PatientAllergicDetails;
use App\Model\PatientFamilyHistory;
use App\Model\PatientPersonalInfo;
use App\Model\PatientSocialHistory;
use App\Model\Payments;
use App\Model\Payout;
use App\Model\Pharmacy;
use App\Model\Prescriptions;
use App\Model\Quotes;
use App\Model\Role;
use App\Model\Sales;
use App\Model\Service;
use App\Model\TaxService;
use App\Model\UserCommissions;
use Illuminate\Support\Facades\Auth;

function getOTP()
{
    $key = mt_rand(100000, 999999);
    $otp = Otp::digits(6)->expiry(10)->generate($key);
    $data['otp'] = $otp;
    $data['key'] = $key;
    return $data;
}

function getAppointmentId()
{
    try {
        $record = Appointments::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'AP' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'AP0000001';
    }
}

function getLaboratoryId()
{
    try {
        $record = LaboratoryInfo::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'LAB' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'LAB0000001';
    }
}
function getPharmacyId()
{
    try {
        $record = Pharmacy::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PHA' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PHA0000001';
    }
}
//TODO delete
// for laboratory test and
function getServicesId($type)
{
    try {
        $record = Service::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = $type . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return $type . '0000001';
    }
}
function getLabTestId()
{
    try {
        $record = LabTest::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'LAT' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'LAT' . '0000001';
    }
}

function getSocialHistoryId()
{
    try {
        $record = PatientSocialHistory::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PSH' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PSH0000001';
    }
}
function getFamilyHistoryId()
{
    try {
        $record = PatientFamilyHistory::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PFH' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PFH0000001';
    }
}
function getAllergicDetailsId()
{
    try {
        $record = PatientAllergicDetails::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PAD' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PAD0000001';
    }
}
function getDoctorId()
{
    try {
        $record = DoctorPersonalInfo::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'D' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'D0000001';
    }
}
function getPatientId()
{
    try {
        $record = PatientPersonalInfo::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'P' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'P0000001';
    }
}
function getRoleId()
{
    try {
        $record = Role::orderBy('id', 'desc')->firstOrFail();
        //length of zero 7
        $record_id = 'RL' . sprintf("%02d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'RL01';
    }
}
function getEmployeeId()
{
    try {
        $record = Employee::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'EMP' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'EMP0000001';
    }
}
function getHealthAssociateId()
{
    try {
        $record = Employee::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'HA' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'HA0000001';
    }
}

function getMedicineSKU($id = NULL)
{
    try {
        if (!is_null($id)) {
            $record_id = 'MED' . sprintf("%07d", $id);
            return $record_id;
        }
        $record = Medicine::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'MED' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'MED0000001';
    }
}

function getPrescriptionId()
{
    try {
        $record = Prescriptions::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PX' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PX0000001';
    }
}

function getQuoteRequestId()
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


function getQuoteId()
{
    try {
        $record = Quotes::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'QT' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'QT0000001';
    }
}

function getPaymentId()
{
    try {
        $record = Payments::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PAY' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PAY0000001';
    }
}

function getUserCommissionId()
{
    try {
        $record = UserCommissions::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'CO' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'CO0000001';
    }
}

function getTaxServiceId()
{
    try {
        $record = TaxService::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'TS' . sprintf("%04d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'TS0001';
    }
}
function getSalesId()
{
    try {
        $record = Sales::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'SL' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'SL0000001';
    }
}
function getPayOutId()
{
    try {
        $record = Payout::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'PY' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'PY0000001';
    }
}
function getOrderId()
{
    try {
        $record = Orders::orderBy('id', 'desc')->withTrashed()->firstOrFail();
        //length of zero 7
        $record_id = 'ORD' . sprintf("%07d", ($record->id + 1));
        return $record_id;
    } catch (\Exception $exception) {

        return 'ORD0000001';
    }
}
function convertToUTC($str, $format = 'Y-m-d H:i:s')
{
    if (is_null($str)) {
        return NULL;
    }
    $new_str = new DateTime($str, new DateTimeZone(getUserTimeZone()));
    $new_str->setTimeZone(new DateTimeZone('UTC'));
    return $new_str->format($format);
}

//this function converts string from UTC time zone to current user timezone
function convertToUser($str, $format = 'Y-m-d H:i:s')
{
    if (is_null($str)) {
        return NULL;
    }
    $new_str = new DateTime($str, new DateTimeZone('UTC'));
    $new_str->setTimeZone(new DateTimeZone(getUserTimeZone()));
    return $new_str->format($format);
}

function getUserTimeZone()
{
    if (Auth::check()) {
        $userTimezone = Auth::user()->timezone;
    } else {

        $userTimezone = !is_null(request()->timezone) ? request()->timezone : config('app.timezone');
    }
    return $userTimezone;
}
