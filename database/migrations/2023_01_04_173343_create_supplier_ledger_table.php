<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_ledger', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('chalan_no')->nullable();
            $table->string('deposit_no')->nullable();
            $table->string('amount')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('d_c')->nullable();
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
        Schema::dropIfExists('supplier_ledger');
    }
};
