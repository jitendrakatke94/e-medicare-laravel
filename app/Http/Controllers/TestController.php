<?php

namespace App\Http\Controllers;

use App\Http\Responses\ErrorMessage;
use App\Http\Responses\SuccessMessage;
use App\Http\Services\ImportService;
use App\Jobs\SendEmailJob;
use App\User;
use Dotenv\Dotenv;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getAllConfig()
    {
        return 404;
        $env = Dotenv::createArrayBacked(base_path())->load();
        $config = config('app');
        return response()->json(['env' => $env, 'config' => $config], 200);
    }

    public function sendMail()
    {
        try {
            SendEmailJob::dispatch(['subject' => 'Emedicare: Developer Test mail', 'user_name' => 'Developer', 'email' => 'theophilus@logidots.com', 'mail_type' => 'otpverification', 'message' => 'Test mail sent successfully']);
            return new SuccessMessage("Test mail sent successfully", 200);
        } catch (\Exception $e) {
            return new ErrorMessage($e->getMessage(), 422);
        }
    }
    public function healthAssociateIdConversion()
    {
        $users = User::where('user_type', 'HEALTHASSOCIATE')->with('employee')->get();
        foreach ($users as $key => $user) {
            $unique_id = $user->employee->unique_id;
            $text = str_replace('EMP', 'HA', $unique_id);
            $user->employee->update(['unique_id' => $text]);
        }

        return new SuccessMessage("Done", 200);
    }


    public function medicineTableSeeding(Request $request)
    {
        return 404;
        $file_path = '/home/theo/Downloads/1mg_2021_06_25.csv';

        $url = $file_path;  /// DEFINE FILE PATH HERE///
        $outputFile = 'stockfile-part-';   /// NAME OF THE FILE IN WHICH NAME YOU WANT TO UPLOAD///
        $splitSize = 50000;  // 50k records in a one file
        $in = fopen($url, 'r');  /// OPEN THE UPLOADED FILE///
        $rows = 0;
        $fileCount = 1;
        $out = null;
        while (($data = fgetcsv($in)) !== FALSE) ///START READ OPERATION OF THE UPLOADED FILE///
        {
            if (($rows % $splitSize) == 0) {
                if ($rows > 0) {
                    fclose($out);
                }
                $fileCount++;
                // for filenames like indiacountry-part-0001.csv, indiacountry-part-0002.csv etc
                $fileCounterDisplay = sprintf("%04d", $fileCount);
                $fileName = "$outputFile$fileCounterDisplay.csv";
                $out = fopen($fileName, 'w');
            }
            //dd($data);
            $final_array = array();
            for ($i = 0; $i < 1; $i++) {
                ///////////////////BELOW ARE INPUT OPERATION FROM EACH ROW OF CSV FILE////
                $importarrays['site_code'] = $data[0];  ///here $data[0], $data[1]....are the each column of csv file///
                $importarrays['category1'] = $data[1];
                $importarrays['category2'] = $data[2];
                $importarrays['category4'] = $data[3];
                $importarrays['division'] = $data[4];
                $importarrays['section'] = $data[5];
                $importarrays['department'] = $data[6];
                $importarrays['barcode'] = $data[7];
                array_push($final_array, $importarrays);
            }
            foreach ($final_array as $arr) {
                // \DB::table('closing_stock')->insert($arr);  //// HERE IS THE DATABASE INSERT OPERATION/////
            }
            $rows++;
        }
        fclose($in);  /// CLOSING THE FILE AFTER COMPLETE FILE READ OPERATION////

        print_r($file_path);

        //$data = (new ImportService)->getHeaderAndData($file_path, 'csv');

        print_r($data);
    }
}
