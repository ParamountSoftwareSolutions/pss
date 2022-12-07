<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::insert([
            /*Marla, Kinal, Acer, Bed, Bath*/
            [
                'name' => 'bed',
            ],
            [
                'name' => 'bath',
            ],
            [
                'name' => 'marla',
            ],
            [
                'name' => 'kinal',
            ],
        ]);
    }
}
