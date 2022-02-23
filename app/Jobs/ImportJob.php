<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\ImportService;
use App\Mail\ImportMail;
use App\Model\Import;
use App\Model\Payout;
use App\Model\PayoutInformation;
use App\User;
use Mail;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $importService, $import, $data, $search, $current_user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Import $import, $data, $search, $current_user)
    {
        $this->importService = new ImportService;
        $this->import = $import;
        $this->data = $data;
        $this->search = $search;
        $this->current_user = $current_user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // in queue job
        $rows = $this->data['data'];
        $errors = array();
        $processed_rows = 0;
        foreach ($rows as $key => $row) {
            $single_row = array_filter($row);

            $validator = $this->importService->validate($single_row);

            if ($validator->fails()) {
                $validator_error = $validator->errors()->toArray();
                $message =  implode(', ', array_map(function ($entry) {
                    return $entry[0];
                }, $validator_error));

                if (!array_key_exists(0, $single_row)) {
                    $single_row[0] = NULL;
                }
                if (!array_key_exists(1, $single_row)) {
                    $single_row[1] = NULL;
                }
                if (!array_key_exists(2, $single_row)) {
                    $single_row[2] = NULL;
                }
                if (!array_key_exists(3, $single_row)) {
                    $single_row[3] = NULL;
                }
                $single_row[4] = $message;
                ksort($single_row);
                $errors[] = $single_row;
                continue;
            } else {

                $single_row = $validator->valid();
                if (!array_key_exists(3, $single_row)) {
                    $single_row[3] = NULL;
                }

                $record = Payout::where('payout_id', $single_row[0])->first();
                if ($record->status == 1) {
                    $single_row[4] = 'There is no payment due for this Payout ID.';
                    $errors[] = $single_row;
                    continue;
                } else {
                    $value = $record->total_payable - $record->total_paid;
                    $data_amount = $single_row[1];
                    if ($data_amount > $value) {
                        $single_row[4] = 'Payable amount is higher than current due Rs. ' . $value;
                        $errors[] = $single_row;
                        continue;
                    } else {
                        // make payment and send mail
                        $total_paid = $record->total_paid + $data_amount;
                        $record->total_paid = $total_paid;

                        $balance = $record->total_payable - $total_paid;
                        $record->balance = $balance;

                        if ($record->total_payable == $total_paid) {
                            $record->status = 1;
                        }
                        $record->save();

                        $info =  PayoutInformation::create([
                            'type' => $record->type,
                            'payout_id' => $record->id,
                            'amount' => $data_amount,
                            'reference' => $single_row[2],
                            'comment' => $single_row[3]
                        ]);
                        $user = User::find($record->type_id);

                        SendEmailJob::dispatch(['name' => $user->last_name, 'email' => $user->email, 'mail_type' => 'payment_notification', 'record' => $record, 'info' => $info]);
                        $processed_rows++;
                    }
                }
            }
        }
        $errors_count = 0;
        $error_file = null;
        if ($errors) {
            $errors_count = count($errors);
            $this->search[] = 'Error Log';
            array_unshift($errors, $this->search);
            $result = $this->importService->generateSpreadsheet($this->import->id, $errors);
            $error_file = $result['attach_file_path'];
            $this->import->error_file = $result['path'];
            $this->import->save();
        }

        $mail_info = [
            'errors_count' => $errors_count,
            'success_count' => $processed_rows,
            'error_file' => $error_file,
            'user' => $this->current_user,
        ];
        Mail::to($this->current_user->email)->send(new ImportMail($mail_info));
    }
}
