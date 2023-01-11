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
        Schema::create('tbl_bank', function (Blueprint $table) {
            $table->id('bankid');
            $table->string('bank_name')->nullable();
            $table->string('ac_name')->nullable();
            $table->string('ac_number')->nullable();
            $table->string('branch')->nullable();
            $table->string('signature_pic')->nullable();
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
        Schema::dropIfExists('tbl_bank');
    }
};
