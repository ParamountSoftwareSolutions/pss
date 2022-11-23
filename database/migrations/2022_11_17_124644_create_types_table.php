<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            /*Society Type:['commercial', 'semi_commercial', 'residential'], Building Type:["apartment","shop","office","flats"] ['studio', 'apartment', 'flat', 'shop', 'penthouse', 'office', ]*/
            $table->foreignId('project_type_id')->unsigned()->nullable()->constrained('project_types')->nullOnDelete();
            $table->string('name');
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
        Schema::dropIfExists('types');
    }
}
