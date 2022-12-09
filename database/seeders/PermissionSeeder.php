<?php

namespace Database\Seeders;

use App\Models\BuildingEmployee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $role1 = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $role2 = Role::create(['name' => 'society_admin', 'guard_name' => 'user']);
        $role3 = Role::create(['name' => 'society', 'guard_name' => 'user']);
        $role4 = Role::create(['name' => 'agent', 'guard_name' => 'user']);
        $role5 = Role::create(['name' => 'sale', 'guard_name' => 'user']);
        $role6 = Role::create(['name' => 'guest', 'guard_name' => 'user']);
        $role7 = Role::create(['name' => 'user', 'guard_name' => 'user']);
        $role8 = Role::create(['name' => 'property_admin', 'guard_name' => 'user']);
        $role9 = Role::create(['name' => 'property_manager', 'guard_name' => 'user']);
        $role10 = Role::create(['name' => 'employee', 'guard_name' => 'user']);
        $role11 = Role::create(['name' => 'sale_manager', 'guard_name' => 'user']);
        $role12 = Role::create(['name' => 'sale_person', 'guard_name' => 'user']);
        $role13 = Role::create(['name' => 'office_staff', 'guard_name' => 'user']);
        $role14 = Role::create(['name' => 'accountant', 'guard_name' => 'user']);




        //1 create demo users
        $user = \App\Models\Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '0934893802943840',
            'password' => Hash::make(12345678),
        ]);
        $user->assignRole($role1);

        //2
        $user = \App\Models\User::factory()->create([
            'name' => 'Society Admin',
            'email' => 'society@admin.com',
            'phone_number' => '093489380093',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role2);

        //3
        $user = \App\Models\User::factory()->create([
            'name' => 'Society',
            'email' => 'x@society.com',
            'phone_number' => '09348938029384091',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role3);

        //4
        $user = \App\Models\User::factory()->create([
            'name' => 'Manger1',
            'email' => 'manger1@society.com',
            'phone_number' => '09348938029384092',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role3);

        //5
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'agent@agent.com',
            'phone_number' => '09348938029384093',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role4);

        //6
        $user = \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'phone_number' => '093489380293840912',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role7);

        //7
        $user = \App\Models\User::factory()->create([
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            'phone_number' => '09348938029384094',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role7);

        //8
        $user = \App\Models\User::factory()->create([
            'name' => 'test2',
            'email' => 'test2@gmail.com',
            'phone_number' => '09348938029384095',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role7);

        //9
        $user = \App\Models\User::factory()->create([
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'phone_number' => '09348938029384096',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role6);

        //10
        $user = \App\Models\User::factory()->create([
            'name' => 'Property Admin',
            'email' => 'property_admin@gmail.com',
            'phone_number' => '09348938029384097',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role8);

        //11
        $user = \App\Models\User::factory()->create([
            'name' => 'Property Manager',
            'email' => 'property_manager@gmail.com',
            'phone_number' => '093489380293840911',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role9);

        //12
        $user = \App\Models\User::factory()->create([
            'name' => 'Sale Manager',
            'email' => 'sale_manager@gmail.com',
            'phone_number' => '0934893802938409112',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role11);

        //13
        $user = \App\Models\User::factory()->create([
            'name' => 'Sale Person',
            'email' => 'sale_person@gmail.com',
            'phone_number' => '09348902938409112',
            'password' => Hash::make(12345678),
            'project' => 10,
        ]);
        $user->assignRole($role12);
    }
}
