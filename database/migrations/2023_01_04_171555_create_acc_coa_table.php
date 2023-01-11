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
        Schema::create('acc_coa', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->integer('HeadCode')->nullable();
            $table->integer('HeadName')->unsigned()->change();
            $table->integer('HeadLevel')->nullable();
            $table->integer('IsActive')->nullable();
            $table->integer('IsTransaction')->nullable();
            $table->integer('IsGL')->nullable();
            $table->string('HeadType')->nullable();
            $table->integer('IsBudget')->nullable();
            $table->integer('IsDepreciation')->nullable();
            $table->integer('DepreciationRate')->nullable();
            $table->string('CreateBy')->nullable();
            $table->string('CreateDate')->nullable();
            $table->string('UpdateBy')->nullable();
            $table->string('UpdateDate')->nullable();
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
        Schema::dropIfExists('acc_coa');
    }
};
