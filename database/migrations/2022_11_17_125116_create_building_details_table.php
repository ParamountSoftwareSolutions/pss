<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->string('developer')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('price')->nullable();
            $table->text('description')->nullable();
            $table->text('plot_feature')->nullable();
            $table->text('communication_feature')->nullable();
            $table->text('community_feature')->nullable();
            $table->text('health_feature')->nullable();
            $table->text('other_feature')->nullable();
            $table->text('property_type')->nullable();
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('building_details');
    }
}
