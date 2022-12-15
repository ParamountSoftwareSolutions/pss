<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unsigned()->constrained('users')->onDelete('set null');
            $table->foreignId('assign_to')->nullable()->unsigned()->constrained('users')->onDelete('set null');
            $table->enum('type', ['client','lead','call','meeting','conversion'])->nullable();
            $table->integer('target')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->integer('achieved')->default(0);
            $table->enum('status',['success', 'pending', 'failed'])->nullable();
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
        Schema::dropIfExists('targets');
    }
}
