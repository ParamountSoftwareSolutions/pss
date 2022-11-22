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
            $table->id();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('number')->unique()->nullable();
            $table->string('alt_number')->nullable();
            $table->string('password')->nullable();
            $table->string('budget_from')->nullable();
            $table->string('Budget_to')->nullable();
            $table->string('source')->nullable();
            $table->string('interested_in')->nullable();
            $table->string('Purpose')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['lead', 'facebook_lead']);
            $table->foreignId('country_id')->unsigned()->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('state_id')->unsigned()->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->unsigned()->nullable()->constrained('cities')->nullOnDelete();
            $table->string('status')->nullable();;
            $table->enum('priority', ['very_hot', 'hot', 'moderate','cold'])->nullable();
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
        Schema::dropIfExists('leads');
    }
}
