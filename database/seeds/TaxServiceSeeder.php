<?php

use App\Model\TaxService;
use Illuminate\Database\Seeder;

class TaxServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxServices = array(
            'Doctor online consultation',
            'Doctor offline consultation',
            'Doctor emergency consultation',
            'Medicine purchase Direct',
            'Medicine purchase Indirect',
            'Lab test Home',
            'Lab test Lab',
        );

        foreach ($taxServices as $taxService) {
            TaxService::firstOrCreate([
                'name' => $taxService
            ], [
                'unique_id' => getTaxServiceId(),
                'name' => $taxService
            ]);
        }
    }
}
