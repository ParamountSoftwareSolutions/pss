<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->unsigned()->nullable()->constrained('clients')->nullOnDelete();
            $table->string('title');
            $table->integer('installment_amount');
            $table->date('due_date')->nullable();
            $table->integer('fine_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('comments')->nullable();
            $table->enum('type', ['installment', 'rent']);
            $table->enum('status', ['paid', 'not_paid']);
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
        Schema::dropIfExists('client_installments');
    }
}
