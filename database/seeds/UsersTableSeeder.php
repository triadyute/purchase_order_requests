<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::find(1);
        $role_manager = Role::find(2);
        $role_senior_manager  = Role::find(3);
        $role_admin  = Role::find(4);
        $role_superuser  = Role::find(5);

        $user = factory(User::class)->create(['email' => 'user@poportal.com', 'department_id' => 1]);
        $user->roles()->attach($role_user);
        $user->save();

        $user2 = factory(User::class)->create(['email' => 'user2@poportal.com', 'department_id' => 1]);
        $user2->roles()->attach($role_user);
        $user2->save();

        $manager = factory(User::class)->create(['email' => 'manager@poportal.com', 'department_id' => 1]);
        $manager->roles()->attach($role_manager);
        $manager->save();

        $manager2 = factory(User::class)->create(['email' => 'manager2@poportal.com', 'department_id' => 1]);
        $manager2->roles()->attach($role_manager);
        $manager2->save();

        $senior_manager = factory(User::class)->create(['email' => 'senior_manager@poportal.com', 'department_id' => 1]);
        $senior_manager->roles()->attach($role_senior_manager);
        $senior_manager->save();

        $senior_manager2 = factory(User::class)->create(['email' => 'senior_manager2@poportal.com', 'department_id' => 1]);
        $senior_manager2->roles()->attach($role_senior_manager);
        $senior_manager2->save();

        $admin = factory(User::class)->create(['email' => 'admin@poportal.com', 'department_id' => 1]);
        $admin->roles()->attach($role_admin);
        $admin->save();

        $superuser = factory(User::class)->create(['email' => 'superuser@poportal.com']);
        $superuser->roles()->attach($role_superuser);
        $superuser->save();
    }
}
