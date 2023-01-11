<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::insert([
            [
                'project_id' => 1,
                'floor_list' => '["1","2","6"]',
                'type' => '["1","2","3"]',
                'apartment_size' => "['1', '2', '3', '4', '5']",
                'area' => '120 sq',
                'created_by' => 10,
            ],
            [
                'project_id' => 2,
                'floor_list' => '["1", "3", "5"]',
                'type' => '["1","2","3"]',
                'apartment_size' => "['1', '2', '3', '4', '5']",
                'area' => '120 sq',
                'created_by' => 10,
            ],
            [
                'project_id' => 3,
                'floor_list' => '["2","3","4","5"]',
                'type' => '["1","2","3"]',
                'apartment_size' => "['1', '2', '3', '4', '5']",
                'area' => '120 sq',
                'created_by' => 10,
            ],
        ]);
    }
}
