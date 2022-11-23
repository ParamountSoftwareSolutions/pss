<?php

namespace Database\Seeders;

use App\Models\NocType;
use Illuminate\Database\Seeder;

class NocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NocType::insert([
            [
                'name' => 'LDA',
            ]
        ]);
    }
}
