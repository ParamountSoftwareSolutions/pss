<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('payment_plan_id')->unsigned()->nullable()->constrained('payment_plans')->nullOnDelete();
            //$table->string('unit_id');
            $table->string('area')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('plot_feature')->nullable();
            $table->text('business_feature')->nullable();
            $table->text('community_feature')->nullable();
            $table->text('healthcare_feature')->nullable();
            $table->text('other_facilities')->nullable();
            $table->foreignId('size_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('bed_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('bath_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->foreignId('type_id')->unsigned()->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
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
        Schema::dropIfExists('properties');
    }
}
