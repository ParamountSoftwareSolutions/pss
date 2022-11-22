<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'    => 'Rehman Saab',
            'email'    => 'admin@gmail.com',
            'password'   =>  Hash::make('password')
        ]);
    }
}
