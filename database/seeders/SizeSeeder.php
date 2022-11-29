<?php

namespace Database\Seeders;

use App\Models\Size;
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
        Size::insert([
            [
                'project_type_id' => 1,
                'unit_id' => 1,
                'name' => 3,
            ],
            [
                'project_type_id' => 1,
                'unit_id' => 2,
                'name' => 3,
            ],
            [
                'project_type_id' => 2,
                'unit_id' => 3,
                'name' => 10,
            ],
            [
                'project_type_id' => 2,
                'unit_id' => 3,
                'name' => 5,
            ],
            [
                'project_type_id' => 2,
                'unit_id' => 3,
                'name' => 3,
            ],
        ]);
    }
}
