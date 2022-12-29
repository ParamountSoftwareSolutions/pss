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
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_type_id')->unsigned()->nullable()->constrained('project_types')->nullOnDelete();
            $table->integer('inventory_id');
            $table->string('status');
            $table->string('name');
            $table->string('email');
            $table->integer('cnic');
            $table->integer('phone_number');
            $table->integer('amount');
            $table->text('comment');
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
        Schema::dropIfExists('inventory_histories');
    }
};
