<?php

namespace Database\Seeders;

use App\Models\Premium;
use Illuminate\Database\Seeder;

class PremiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Premium::insert([
            [
                'project_type_id' => 1,
                'name' => 'Corner',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Main-Boulevard',
            ],
            [
                'project_type_id' => 1,
                'name' => 'Park-Facing',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Corner',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Main-Boulevard',
            ],
            [
                'project_type_id' => 2,
                'name' => 'Park-Facing',
            ],
        ]);
    }
}
