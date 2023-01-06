<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->unsigned()->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('user_id')->unsigned()->nullable()->constrained('users')->nullOnDelete();
            $table->integer('transfer_to');
            $table->integer('inventory_id');
            $table->integer('project_type_id');
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->text('price')->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('client_histories');
    }
}
