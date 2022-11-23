<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            //$table->foreignId('sale_manager_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('cnic')->unique();
            $table->string('address')->nullable();
            $table->string('account_no')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('commission')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
