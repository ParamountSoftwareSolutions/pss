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
        Schema::create('lead_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->unsigned()->nullable()->constrained('leads')->nullOnDelete();
            // $table->foreignId('client_id')->unsigned()->nullable()->constrained('clients')->nullOnDelete();
            // $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('call_status')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('call_time')->nullable();
            $table->string('is_read')->nullable();
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
        Schema::dropIfExists('lead_histories');
    }
};
