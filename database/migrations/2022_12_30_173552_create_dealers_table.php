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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('cnic')->unique()->nullable();
            $table->string('number')->unique()->nullable();
            $table->string('alt_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('agency')->nullable();
            $table->integer('actual_amount')->nullable();
            $table->string('rebate')->nullable();
            $table->integer('token')->nullable();
            $table->integer('received')->nullable();
            $table->integer('pending')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('dealers');
    }
};
