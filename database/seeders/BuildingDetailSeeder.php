<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::insert([
            [
                'name' => 'Sewerage',
                'key' => 'plot',
            ],
            [
                'name' => 'Electricity',
                'key' => 'plot',
            ],
            [
                'name' => 'Water Supply',
                'key' => 'plot',
            ],
            [
                'name' => 'BroadBand',
                'key' => 'communication',
            ],
            [
                'name' => 'ATM',
                'key' => 'communication',
            ],
            [
                'name' => 'Gym',
                'key' => 'community',
            ],
            [
                'name' => 'Swimming Pool',
                'key' => 'health',
            ],
            [
                'name' => 'Suna',
                'key' => 'health',
            ],
            [
                'name' => 'Jacuzzi',
                'key' => 'health',
            ],
            [
                'name' => 'NearBy School',
                'key' => 'other',
            ],
            [
                'name' => 'Hospitals',
                'key' => 'other',
            ],
            [
                'name' => 'Shopping Mall',
                'key' => 'other',
            ],
            [
                'name' => 'Restaurant',
                'key' => 'other',
            ],
            [
                'name' => 'Public Transport',
                'key' => 'other',
            ],
            [
                'name' => 'Services',
                'key' => 'other',
            ],
            [
                'name' => 'Maintenance',
                'key' => 'other',
            ],
            [
                'name' => 'Security Staff',
                'key' => 'other',
            ]
        ]);
    }
}
