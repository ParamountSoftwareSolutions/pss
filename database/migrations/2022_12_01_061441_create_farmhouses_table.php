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
        Schema::create('farmhouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->foreignId('block_id')->unsigned()->nullable()->constrained('blocks')->nullOnDelete();
            $table->string('unit_no')->nullable();
            $table->foreignId('size_id')->unsigned()->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('premium_id')->unsigned()->nullable()->constrained('premia')->nullOnDelete();
            $table->enum('status', ['available', 'hold', 'sold','token','canceled'])->default('available');
            $table->foreignId('payment_plan_id')->unsigned()->nullable()->constrained('payment_plans')->nullOnDelete();
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
        Schema::dropIfExists('farmhouses');
    }
};
