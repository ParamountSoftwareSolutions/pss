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
        Schema::create('acc_transaction', function (Blueprint $table) {
            $table->id('ID');
            $table->string('VNo')->nullable();
            $table->string('Vtype')->nullable();
            $table->string('COAID')->nullable();
            $table->string('Narration')->nullable();
            $table->string('Debit')->nullable();
            $table->string('Credit')->nullable();
            $table->integer('StoreID')->nullable();
            $table->string('IsPosted')->nullable();
            $table->string('CreateBy')->nullable();
            $table->string('UpdateBy')->nullable();
            $table->string('CreateDate')->nullable();
            $table->string('UpdateDate')->nullable();
            $table->string('IsAppove')->nullable();
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
        Schema::dropIfExists('acc_transaction');
    }
};
