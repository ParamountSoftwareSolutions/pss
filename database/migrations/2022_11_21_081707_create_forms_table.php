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
            $table->foreignId('client_id')->unsigned()->nullable()->constrained('clients')->onDelete('cascade');
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->onDelete('cascade');
            $table->text('project_logo')->nullable();
            $table->text('barcode')->nullable();
            $table->string('application_no')->nullable();
            $table->integer('fee')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('phone_no_office')->nullable();
            $table->string('phone_no_res')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_father_name')->nullable();
            $table->string('nominee_cnic')->nullable();
            $table->string('nominee_passport_no')->nullable();
            $table->string('relationship')->nullable();
            $table->string('property_type')->nullable();
            $table->string('total_price')->nullable();
            $table->string('booking_price')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('installment')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('cash_receipt')->nullable();
            $table->enum('type', ['membership'])->nullable();
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
