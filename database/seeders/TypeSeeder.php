<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::insert([
            [
                'project_type_id' => 1,
                'name' => 'commercial',
            ],
            [
                'project_type_id' => 1,
                'name' => 'semi_commercial',
            ],
            [
                'project_type_id' => 1,
                'name' => 'residential',
            ],
            [
                'project_type_id' => 2,
                'name' => 'commercial',
            ],
            [
                'project_type_id' => 2,
                'name' => 'semi_commercial',
            ],
            [
                'project_type_id' => 2,
                'name' => 'residential',
            ],
            [
                'project_type_id' => 3,
                'name' => 'commercial',
            ],
            [
                'project_type_id' => 3,
                'name' => 'semi_commercial',
            ],
            [
                'project_type_id' => 3,
                'name' => 'residential',
            ],
        ]);
    }
}
