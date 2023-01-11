<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('amount');
            $table->string('payment_method')->nullable();
            $table->string('name')->nullable();
            $table->integer('working_days')->nullable();
            $table->integer('present_days')->nullable();
            $table->integer('absent_days')->nullable();
            $table->integer('total_leaves')->nullable();
            $table->integer('leaves_approved')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('advance')->nullable();
            $table->integer('comments')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('employee_payrolls');
    }
}
