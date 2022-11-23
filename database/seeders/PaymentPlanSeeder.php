<?php

namespace Database\Seeders;

use App\Models\PaymentPlan;
use Illuminate\Database\Seeder;

class PaymentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlan::create([
            'property_admin_id' => 10,
            'name' => 'Default',
            'total_month_installment' => 48,
            'total_price' => 2100000,
            'booking_price' => 200000,
            //'form_submission' => 50000,
            'per_month_installment' => 15000,
            'half_year_installment' => 60000,
            'balloting_price' => 400000,
            'possession_price' => 300000,
        ]);
    }
}
