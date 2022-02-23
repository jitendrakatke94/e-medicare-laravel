<?php

use Illuminate\Database\Seeder;
use App\Model\Specializations;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = array(
            'Orthopedician',
            'Dermatologist',
            'Pediatrician',
            'General Physician',
            'General Surgeon',
            'Cardiologist',
            'Dietitian',
            'Pulmonologist',
            'Gynecologist',
            'Gastroenterologist',
            'Fertility Specialist',
            'Oncologist',
            'Urologist',
            'Neurosurgeon',
            'Endocrinologist',
            'Nephrologist',
            'Neurologist',
            'Sports Medicine',
            'Diabetologist',
            'Cosmetologist',
            'Andrologist',
            'Psychiatrist',
            'Dentist',
            'Psychotherapist',
        );

        foreach ($specializations as $specialization) {
            Specializations::firstOrCreate([
                'name' => $specialization
            ]);
        }
    }
}
