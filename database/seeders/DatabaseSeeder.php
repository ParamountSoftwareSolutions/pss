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
            BlockSeeder::class,
            TypeSeeder::class,
            ProjectAssignUserSeeder::class,
            NocTypeSeeder::class,
            SizeSeeder::class,
            PaymentPlanSeeder::class,
            PremiumSeeder::class,
            BuildingFloorSeeder::class,
            BuildingSeeder::class,
            BuildingDetailSeeder::class,
            SocietySeeder::class,
            SocietyInventorySeeder::class,
        ]);
    }
}
