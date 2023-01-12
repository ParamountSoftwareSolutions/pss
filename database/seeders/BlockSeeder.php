<?php

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Block::insert([
            [
                'project_type_id' => 2,
                'name' => 'Y block',
            ],
            [
                'project_type_id' => 2,
                'name' => 'x block',
            ],
            [
                'project_type_id' => 2,
                'name' => 'z block',
            ],
            [
                'project_type_id' => 2,
                'name' => 'cream block',
            ],
            [
                'project_type_id' => 2,
                'name' => 'so block',
            ],[
                'project_type_id' => 3,
                'name' => 'Y block',
            ],
            [
                'project_type_id' => 3,
                'name' => 'x block',
            ],
            [
                'project_type_id' => 3,
                'name' => 'z block',
            ],
            [
                'project_type_id' => 3,
                'name' => 'cream block',
            ],
            [
                'project_type_id' => 3,
                'name' => 'so block',
            ],
        ]);
    }
}
