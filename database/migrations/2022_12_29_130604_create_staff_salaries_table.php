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
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_id')->nullable();
            $table->string('salary')->nullable();
            $table->string('basic')->nullable();
            $table->string('da')->nullable();
            $table->string('hra')->nullable();
            $table->string('conveyance')->nullable();
            $table->string('allowance')->nullable();
            $table->string('medical_allowance')->nullable();
            $table->string('esp')->nullable();
            $table->string('pf')->nullable();
            $table->string('leave')->nullable();
            $table->string('prof_tax')->nullable();
            $table->string('labour_welfare')->nullable();
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
        Schema::dropIfExists('staff_salaries');
    }
};
