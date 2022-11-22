<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocietyInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('society_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->unsigned()->nullable()->constrained('societies')->nullOnDelete();
            $table->foreignId('category_id')->unsigned()->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('payment_plan_id')->unsigned()->nullable()->constrained('payment_plans')->nullOnDelete();
            //$table->foreignId('type_id')->unsigned()->nullable()->constrained('types')->nullOnDelete();
            $table->foreignId('size_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->integer('quantity')->nullable();
            $table->foreignId('created_by_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('status_id')->unsigned()->nullable()->constrained('statuses')->nullOnDelete();
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
        Schema::dropIfExists('society_inventories');
    }
}
