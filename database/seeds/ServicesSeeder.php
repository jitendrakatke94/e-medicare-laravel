<?php

use Illuminate\Database\Seeder;
use App\Model\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = array(
            'Complete Blood Count - CBC',
            'Prothrombin Time - PT',
            'Basic Metabolic Panel',
            'Comprehensive Metabolic Panel',
            'Lipid Panel',
            'Liver Panel',
            'Thyroid Stimulating Hormone',
            'Hemoglobin A1C',
            'Urinalysis'
        );

        $seeds = array(
            'LAB' => array(
                'Complete Blood Count - CBC',
                'Prothrombin Time - PT',
                'Basic Metabolic Panel',
                'Comprehensive Metabolic Panel',
                'Lipid Panel',
                'Liver Panel',
                'Thyroid Stimulating Hormone',
                'Hemoglobin A1C',
                'Urinalysis'
            ),
            'MED' => array(
                'Amifostine',
                'Amikacin',
                'Aminocaproic Acid',
                'Amitriptyline',
                'Amlodipine',
                'Amoxicillin',
            )
        );

        foreach ($seeds as $key => $value) {

            foreach ($value as $seed) {
                Service::firstOrCreate([
                    'name' => $seed,
                    'type' => $key
                ], [
                    'unique_id' => getServicesId($key),
                    'created_by' => 1
                ]);
            }
        }
    }
}
