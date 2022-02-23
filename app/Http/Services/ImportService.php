<?php

namespace App\Http\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use File;
use Illuminate\Support\Facades\Storage;
use Validator;

class ImportService
{
    public function getHeaderAndData($path, $extension)
    {
        $importData = $this->readFile($path, $extension);
        $headers = array_values(array_filter(array_map(function ($data) {
            return [
                'header' => trim($data),
                'field_to_be_mapped' => ''
            ];
        }, $importData[0]), function ($data) {
            return $data['header'];
        }));

        if (count($headers) < 1) {
            throw new \Exception('At least 1 column is required while importing data.');
        }
        $rawHeader = $importData[0];
        unset($importData[0]);
        return [
            'raw_header' => $rawHeader,
            'headers' => $headers,
            'data' => array_values($importData)
        ];
    }

    public function readFile($file, $extension)
    {
        try {

            if ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else if ($extension == ("csv" || "txt")) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                throw new \Exception("Invalid File Format");
            }
        } catch (\Exception $e) {
            throw new \Exception("Invalid File Format");
        }
        try {
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);
            return $reader->load($file)->getActiveSheet()->toArray();
        } catch (\Throwable $th) {
            throw new \Exception("Invalid File Format");
        }
    }

    public function validate($data)
    {
        return  Validator::make($data, [
            '0' => 'required|exists:payouts,payout_id',
            '1' => 'required|numeric',
            '2' => 'required',
        ], [
            '0.required'    => 'Payout ID is empty.',
            '0.exists'      => 'Payout ID is invalid.',
            '1.required'    => 'Amount is empty.',
            '0.numeric'     => 'Amount must be of number.',
            '2.required'    => 'Payment Reference is empty.',
        ]);
    }

    public function generateSpreadsheet($import_id = NULL, $errors)
    {
        $spreadsheet = new Spreadsheet();
        $writer = $spreadsheet->getActiveSheet();
        $writer->fromArray($errors);


        $path = '';
        if (!is_null($import_id)) {
            if (!File::exists(storage_path() . '/app/public/uploads/import_errors')) {
                File::makeDirectory(storage_path() . '/app/public/uploads/import_errors');
            }
            $path = "public/uploads/import_errors/Bulk_Payout_Import_Errors_" . $import_id . "_" . date("Y-m-d_H-i-s", time()) . ".xlsx";
        } else {
            if (!File::exists(storage_path() . '/app/public/uploads/Report')) {
                File::makeDirectory(storage_path() . '/app/public/uploads/Report');
            }
            $path = "public/uploads/Report/Report_" . date("Y-m-d_H-i-s", time()) . ".xlsx";
        }
        \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);

        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet))
            ->setPreCalculateFormulas(false)
            ->save(storage_path() . '/app/' . $path);

        return [
            'attach_file_path' => storage_path() . '/app/' . $path,
            'path' => $path,
        ];
    }
}
