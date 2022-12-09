<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocietyInventoryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('society_inventory_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_inventory_id')->unsigned()->nullable()->constrained('society_inventories')->nullOnDelete();
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
        Schema::dropIfExists('society_inventory_files');
    }
}
