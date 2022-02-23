<?php

use Illuminate\Database\Seeder;
//use Spatie\Permission\Models\Role;
use App\Model\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Patient',
            'Doctor',
            'Pharmacist',
            'Laboratory',
            'Employee',
            'Health Associate',
            'Payment Admin'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                [
                    'name' => implode("_", explode(" ", strtolower($role)))
                ],
                [
                    'title' => $role,
                    'unique_id' => getRoleId()
                ]
            );
        }
    }
}
