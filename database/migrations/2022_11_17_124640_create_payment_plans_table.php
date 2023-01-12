<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->unsigned()->nullable()->constrained('project_types')->nullOnDelete();
            $table->string('name');
            $table->integer('total_price')->nullable();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->integer('commission')->nullable();
            $table->integer('after_commission_price')->nullable();
            $table->integer('down_payment')->nullable();
            $table->integer('confirmation_amount')->nullable();
            $table->integer('balloting_price')->nullable();
            $table->integer('possession_price')->nullable();
            $table->integer('no_of_month')->nullable();
            $table->integer('monthly_installment')->nullable();
            $table->integer('no_of_half')->nullable();
            $table->integer('half_year_installment')->nullable();
            $table->integer('no_of_quarter')->nullable();
            $table->integer('quarterly_installment')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('rent_price')->nullable();
            $table->integer('rent_installment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_plans');
    }
}
