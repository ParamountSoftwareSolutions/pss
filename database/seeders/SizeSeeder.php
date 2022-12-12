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
                'name' => 3,
                'unit' => 'bed',
            ],
            [
                'project_type_id' => 1,
                'name' => 3,
                'unit' => 'bath'
            ],
            [
                'project_type_id' => 2,
                'name' => 10,
                'unit' => 'marla',
            ],
            [
                'project_type_id' => 2,
                'name' => 5,
                'unit' => 'marla'
            ],
            [
                'project_type_id' => 2,
                'name' => 3,
                'unit' => 'kanal'
            ],
        ]);
    }
}
