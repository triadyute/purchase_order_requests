<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'User',
            'description' => 'Line Staff'
        ]);
        Role::create([
            'name' => 'Manager',
            'description' => 'Manager'
        ]);
        Role::create([
            'name' => 'Senior Manager',
            'description' => 'Senior Manager'
        ]);
        Role::create([
            'name' => 'Admin',
            'description' => 'Admin'
        ]);
        Role::create([
            'name' => 'Superuser',
            'description' => 'Superuser'
        ]);
    }
}
