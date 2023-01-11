<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('Society')->nullable();
            $table->string('SocietyQuantity')->nullable();
            $table->string('Farmhouse')->nullable();
            $table->string('FarmhouseQuantity')->nullable();
            $table->string('Building')->nullable();
            $table->string('BuildingQuantity')->nullable();
            $table->string('Property')->nullable();
            $table->string('PropertyQuantity')->nullable();
            $table->string('lead_module')->nullable();
            $table->string('facebook_lead_module')->nullable();
            $table->string('warid')->nullable();
            $table->string('jazz')->nullable();
            $table->string('Ufone')->nullable();
            $table->string('zong')->nullable();
            $table->string('Email')->nullable();
            $table->string('WhatsApp')->nullable();
            $table->string('Paypal')->nullable();
            $table->string('Bank_transfer')->nullable();
            $table->string('Easypaisa')->nullable();
            $table->string('Jazzcash')->nullable();
            $table->string('bill_management')->nullable();
            $table->string('application_management')->nullable();
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
        Schema::dropIfExists('admin_permissions');
    }
};
