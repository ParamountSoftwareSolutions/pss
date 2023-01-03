<?php

namespace Database\Seeders;

use App\Models\SocietyInventory;
use Illuminate\Database\Seeder;

class SocietyInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocietyInventory::insert([
            [
                'project_id' => 4,
                'society_id' => 1,
                'block_id' => 1,
                'category_id' => 7,
                'payment_plan_id' => 1,
                'type_id' => 4,
                'size_id' => 3,
                'bed_id' => 1,
                'bath_id' => 2,
                'premium_id' => 1,
                'created_by' => 9,
                'status' => 'available',
            ],
            [
                'project_id' => 4,
                'society_id' => 1,
                'block_id' => 1,
                'category_id' => 9,
                'payment_plan_id' => 1,
                'type_id' => 4,
                'size_id' => 3,
                'bed_id' => 1,
                'bath_id' => 2,
                'premium_id' => 1,
                'created_by' => 9,
                'status' => 'available',
            ],
            [
                'project_id' => 4,
                'society_id' => 1,
                'block_id' => 1,
                'category_id' => 10,
                'payment_plan_id' => 1,
                'type_id' => 4,
                'size_id' => 3,
                'bed_id' => 1,
                'bath_id' => 2,
                'premium_id' => 1,
                'created_by' => 9,
                'status' => 'available',
            ]
        ]);
    }
}
