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
        Schema::create('lead_refer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->unsigned()->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignId('from')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('to')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            // $table->integer('from');
            // $table->integer('to');
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
        Schema::dropIfExists('lead_refers');
    }
};
