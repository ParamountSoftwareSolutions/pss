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
                'project_type_id' => 1,
                'name' => 'bed',
            ],
            [
                'project_type_id' => 1,
                'name' => 'bath',
            ],
            [
                'project_type_id' => 2,
                'name' => 'marla',
            ],
            [
                'project_type_id' => 2,
                'name' => 'kinal',
            ],
        ]);
    }
}
