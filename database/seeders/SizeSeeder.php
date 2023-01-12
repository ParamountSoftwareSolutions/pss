<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Unit::insert([
//            [
//                'name' => 'bed',
//            ],
//            [
//                'name' => 'bath',
//            ],
//            [
//                'name' => 'marla',
//            ],
//            [
//                'name' => 'kenal',
//            ],
//        ]);
        Size::insert([
            [
                'project_type_id' => 2,
                'name' => '3 Marla',
            ],[
                'project_type_id' => 2,
                'name' => '5 Marla',
            ],[
                'project_type_id' => 2,
                'name' => '10 Marla',
            ],[
                'project_type_id' => 2,
                'name' => '1 Kenal',
            ],[
                'project_type_id' => 3,
                'name' => '3 Marla',
            ],[
                'project_type_id' => 3,
                'name' => '5 Marla',
            ],[
                'project_type_id' => 3,
                'name' => '10 Marla',
            ],[
                'project_type_id' => 3,
                'name' => '1 Kenal',
            ],
        ]);
    }
}
