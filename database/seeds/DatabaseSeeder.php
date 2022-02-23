<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RolesSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TaxServiceSeeder::class);
        //$this->call(DummyDataSeeder::class);
    }
}
