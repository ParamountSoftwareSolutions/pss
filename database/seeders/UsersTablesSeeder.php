<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
            'name' => 'Rehman Saab',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' =>  str_random(10),
        ]);
    }
}
