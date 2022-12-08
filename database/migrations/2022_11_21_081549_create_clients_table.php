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
            $table->integer('project_type_id')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->foreignId('customer_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('registration_number')->nullable();
            $table->string('hidden_file_number')->nullable();
            $table->integer('down_payment')->nullable();
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
