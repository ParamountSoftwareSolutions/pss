<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectType;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectType::insert([
            [
                'name' => 'building',
            ],
            [
                'name' => 'society',
            ],
            [
                'name' => 'farm_house',
            ],
        ]);

        Project::insert([
            [
                'name' => 'Zaitoon City',
                'type_id' => 1
            ],
            [
                'name' => 'Al Fathy',
                'type_id' => 1
            ],
            [
                'name' => 'Maham Apartment',
                'type_id' => 1
            ],
            [
                'name' => 'Al_Raheem Garden',
                'type_id' => 2,
            ],
            [
                'name' => 'DHA Phase 1',
                'type_id' => 2,
            ],
            [
                'name' => 'Smart City',
                'type_id' => 2,
            ],
            [
                'name' => 'Ch House',
                'type_id' => 3,
            ],
            [
                'name' => 'jutt house',
                'type_id' => 3,
            ],
            [
                'name' => 'shujaat House',
                'type_id' => 3,
            ],
        ]);


    }
}
