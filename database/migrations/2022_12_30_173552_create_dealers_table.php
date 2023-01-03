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
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('cnic')->unique()->nullable();
            $table->string('number')->unique()->nullable();
            $table->string('alt_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->integer('status')->default(1);
            $table->integer('actual_amount')->nullable();
            $table->integer('rebate')->nullable();
            $table->integer('down_payment')->nullable();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->text('inventory_list')->nullable();
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
