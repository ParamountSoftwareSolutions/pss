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
        Schema::create('acc_income_expence', function (Blueprint $table) {
            $table->id('ID');
            $table->string('VNo')->nullable();
            $table->string('Student_Id')->nullable();
            $table->string('Date')->nullable();
            $table->string('Paymode')->nullable();
            $table->string('Perpose')->nullable();
            $table->string('Narration')->nullable();
            $table->string('StoreID')->nullable();
            $table->string('COAID')->nullable();
            $table->string('Amount')->nullable();
            $table->string('IsApprove')->nullable();
            $table->string('CreateBy')->nullable();
            $table->string('CreateDate')->nullable();
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
        Schema::dropIfExists('acc_income_expence');
    }
};
