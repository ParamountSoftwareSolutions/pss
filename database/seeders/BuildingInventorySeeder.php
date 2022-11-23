<?php

namespace Database\Seeders;

use App\Models\BuildingInventory;
use Illuminate\Database\Seeder;

class BuildingInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingInventory::insert([
            [
                'building_id' => 1,
                'floor_id' => 1,
                'unit_id' => '1201',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 1,
                'floor_id' => 2,
                'unit_id' => '1202',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 1,
                'floor_id' => 6,
                'unit_id' => '1203',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'apartment',
                'status' => 'available',
            ],
            [
                'building_id' => 2,
                'floor_id' => 1,
                'unit_id' => '1204',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 2,
                'floor_id' => 3,
                'unit_id' => '1205',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 2,
                'floor_id' => 5,
                'unit_id' => '1206',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 3,
                'floor_id' => 2,
                'unit_id' => '1207',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 3,
                'floor_id' => 3,
                'unit_id' => '1208',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
            [
                'building_id' => 3,
                'floor_id' => 4,
                'unit_id' => '1209',
                'area' => '120',
                'size' => '2',
                'payment_plan_id' => 1,
                'type' => 'studio',
                'status' => 'available',
            ],
        ]);
    }
}
