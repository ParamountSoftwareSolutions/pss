<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'project_type_id' => 2,
                'name' => 'Plot',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Villa',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Apartment',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Commercial',
            ],
        ]);
    }
}
