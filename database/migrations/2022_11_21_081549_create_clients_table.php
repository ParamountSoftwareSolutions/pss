<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->integer('project_id')->nullable();
            $table->integer('project_type_id')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->foreignId('customer_id')->unsigned()->nullable()->constrained('leads')->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('registration_number')->nullable();
            $table->string('hidden_file_number')->nullable();
            $table->integer('down_payment')->nullable();


            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('number')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('cnic')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            
            
            
            $table->string('source')->nullable();
            $table->enum('priority', ['very_hot', 'hot', 'moderate', 'cold'])->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
