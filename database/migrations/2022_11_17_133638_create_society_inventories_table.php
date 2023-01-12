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
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('society_id')->unsigned()->nullable()->constrained('societies')->nullOnDelete();
            $table->foreignId('block_id')->unsigned()->nullable()->constrained('blocks')->nullOnDelete();
            $table->foreignId('category_id')->unsigned()->nullable()->constrained('categories')->nullOnDelete();
            $table->string('unit_id');
            $table->foreignId('payment_plan_id')->unsigned()->nullable()->constrained('payment_plans')->nullOnDelete();
            $table->foreignId('type_id')->unsigned()->nullable()->constrained('types')->nullOnDelete();
            $table->foreignId('size_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->integer('bed')->nullable();
            $table->integer('bath')->nullable();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['available', 'hold', 'sold','token','canceled'])->default('available');
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
