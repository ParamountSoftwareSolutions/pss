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
        Schema::create('dealer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->unsigned()->nullable()->constrained('dealers')->nullOnDelete();
            $table->string('code')->nullable();
            $table->integer('amount')->nullable();
            $table->string('key')->nullable();
            $table->foreignId('project_id')->unsigned()->nullable()->constrained('projects')->nullOnDelete();
            $table->integer('inventory_id')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('dealer_histories');
    }
};
