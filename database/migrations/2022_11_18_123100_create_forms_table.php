<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->unsigned()->nullable()->constrained('users')->onDelete('cascade');
            $table->string('project_name');
            $table->text('project_logo');
            $table->text('developer_logo');
            $table->string('application_no');
            $table->integer('fee');
            $table->string('passport_no');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('occupation');
            $table->string('phone_no_office');
            $table->string('phone_no_res');
            $table->string('nominee_name');
            $table->string('nominee_father_name');
            $table->string('nominee_cnic');
            $table->string('nominee_passport_no');
            $table->string('relationship');
            $table->string('property_type');
            $table->string('total_price');
            $table->string('booking_price');
            $table->string('down_payment');
            $table->string('installment');
            $table->string('payment_type');
            $table->string('cash_receipt');
            $table->enum('type', ['membership']);
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
        Schema::dropIfExists('forms');
    }
}
