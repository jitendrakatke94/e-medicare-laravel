<?php

namespace App\Jobs;

use App\Model\Medicine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file_path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->file_path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return 404;
        try {
            $csv = $this->parse();
            /*
            [0] => url --not used
            [1] => id --not used
            [2] => name
            [3] => manufacturer
            [4] => mrp
            [5] => discount_price --not used
            [6] => price_quantity
            [7] => unit_cost
            [8] => prescription_required
            [9] => salt_composition
            [10] => storage --not used
            [11] => images--not used
            [12] => description
            [13] => alternate_brands --not used
        */
            $i = 0;
            foreach ($csv as $row) {

                if ($i == 0) {
                    $i++;
                    continue;
                }
                if ($row[8] == 'Yes') {
                    $data['rx_required'] = 1;
                }
                $data['name'] = $row[2];
                $data['manufacturer'] = $row[3];
                $data['price_per_strip'] = $row[4];
                $data['rate_per_unit'] = $row[7];
                $data['composition'] = $row[9];
                $data['short_desc'] = $row[12];
                $data['weight_unit'] = $row[6];

                $medicine = Medicine::updateOrCreate(
                    [
                        'name' => $data['name']
                    ],
                    $data
                );
                if ($medicine->wasRecentlyCreated) {
                    $medicine->sku = getMedicineSKU($medicine->id);
                    $medicine->save();
                }
                $i++;
            }
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    public function parse()
    {
        $file = fopen($this->file_path, 'r');
        while (!feof($file)) {
            yield fgetcsv($file);
        }
        return;
    }
}
