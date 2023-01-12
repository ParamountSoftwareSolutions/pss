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
        Schema::create('farmhouse_inventory_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmhouse_inventory_id')->unsigned()->nullable()->constrained('farmhouse_inventories')->nullOnDelete();
            $table->text('file');
            $table->string('type');
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
        Schema::dropIfExists('farmhouse_inventory_files');
    }
};
