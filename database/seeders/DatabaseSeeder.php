<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            //CitySeeder::class,
            ProjectSeeder::class,
            ProjectAssignUserSeeder::class,
            NocTypeSeeder::class,
            UnitSeeder::class,
            SizeSeeder::class,
            PremiumSeeder::class,
            BuildingFloorSeeder::class,
            BuildingSeeder::class,
        ]);
    }
}
