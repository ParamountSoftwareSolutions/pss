<?php

namespace Database\Seeders;

use App\Models\PaymentPlan;
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
        $this->call([
            PermissionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            //CitySeeder::class,
            ProjectSeeder::class,
            CategorySeeder::class,
            ProjectAssignUserSeeder::class,
            PaymentPlanSeeder::class,
            NocTypeSeeder::class,
            UnitSeeder::class,
            SizeSeeder::class,
            PremiumSeeder::class,
            BuildingFloorSeeder::class,
            BuildingSeeder::class,
        ]);
    }
}
