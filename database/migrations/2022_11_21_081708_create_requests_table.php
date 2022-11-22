<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('buildings')->onDelete('cascade');
            $table->integer('project_type_id')->nullable();
            $table->integer('inventory_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->foreignId('transfer_to')->unsigned()->nullable()->constrained('users')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cnic')->nullable();
            $table->enum('type', ['transfer', 'possession', 'file', 'reserve'])->default('possession');
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
        Schema::dropIfExists('requests');
    }
}
