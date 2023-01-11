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
        Schema::create('bank_summary', function (Blueprint $table) {
       
            $table->string('bank_id')->nullable();
            $table->string('description')->nullable();
            $table->string('deposite_id')->nullable();
            $table->string('date')->nullable();
            $table->string('ac_type')->nullable();
            $table->string('dr')->nullable();
            $table->string('cr')->nullable();
            $table->string('ammount')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('bank_summary');
    }
};
