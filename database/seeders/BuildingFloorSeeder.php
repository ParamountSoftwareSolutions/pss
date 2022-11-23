<?php

namespace Database\Seeders;

use App\Models\BuildingFloor;
use Illuminate\Database\Seeder;

class BuildingFloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingFloor::insert([
            [
                'name' => 'Basement 1'
            ],
            [
                'name' => 'Basement 2'
            ],
            [
                'name' => 'Basement 3'
            ],
            [
                'name' => 'Basement 4'
            ],
            [
                'name' => 'Basement 5'
            ],
            [
                'name' => 'Lower Ground'
            ],
            [
                'name' => 'Ground'
            ],
            [
                'name' => 'Mezzanine'
            ],
            [
                'name' => 'First'
            ],
            [
                'name' => 'Second'
            ],
            [
                'name' => 'Third'
            ],
            [
                'name' => 'Forth'
            ],
            [
                'name' => 'Fifth'
            ],
            [
                'name' => 'Sixth'
            ],
            [
                'name' => 'Seventh'
            ],
            [
                'name' => 'Eighth'
            ],
            [
                'name' => 'Nineth'
            ],
            [
                'name' => 'Tenth'
            ],
            [
                'name' => 'Eleventh'
            ],
            [
                'name' => 'Twelfth'
            ],
            [
                'name' => 'Thirteenth'
            ],
            [
                'name' => 'Fourteenth'
            ],
            [
                'name' => 'Fifteenth'
            ],
            [
                'name' => 'Sixteenth'
            ],
            [
                'name' => 'Seventeenth'
            ],
            [
                'name' => 'Eighteenth'
            ],
            [
                'name' => 'Nineteenth'
            ],
            [
                'name' => 'Twentieth'
            ]
        ]);
    }
}
