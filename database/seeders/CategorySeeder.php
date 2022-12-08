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
                'project_type_id' => 1,
                'name' => 'Shop',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Apartment',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Office',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Flats',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Studio',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Pent House',
            ],
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
