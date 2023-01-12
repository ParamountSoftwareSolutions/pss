<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->unsigned()->nullable()->constrained('buildings')->nullOnDelete();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('building_floor_id')->unsigned()->nullable()->constrained('building_floors')->nullOnDelete();
            $table->foreignId('payment_plan_id')->unsigned()->nullable()->constrained('payment_plans')->nullOnDelete();
            $table->string('unit_id');
            $table->string('area')->nullable();
            $table->integer('bed')->nullable();
            $table->integer('bath')->nullable();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->foreignId('type_id')->unsigned()->nullable()->constrained('types')->nullOnDelete();
            $table->foreignId('category_id')->unsigned()->nullable()->constrained('categories')->nullOnDelete();
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
        Schema::dropIfExists('building_inventories');
    }
}
