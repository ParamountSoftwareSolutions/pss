<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
           // Schema::dropIfExists('leads');
            $table->id();
            $table->integer('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('number');
            $table->string('alt_number')->nullable();
            $table->string('budget_from')->nullable();
            $table->string('budget_to')->nullable();
            $table->string('purpose')->nullable();
            $table->string('source')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->enum('type', ['lead', 'facebook_lead']);
            $table->foreignId('country_id')->unsigned()->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('state_id')->unsigned()->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->unsigned()->nullable()->constrained('cities')->nullOnDelete();
            $table->enum('priority', ['very_hot', 'hot', 'moderate', 'cold'])->nullable();
            $table->string('status')->default('new');
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
        Schema::drop('leads');
    }
}
