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
            $table->string('developer')->nullable();
            $table->text('type')->nullable();
            $table->text('block')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('area')->nullable();
            $table->text('social_media')->nullable();/*Json data save*/
            $table->foreignId('created_by')->unsigned()->nullable()->constrained('users')->onDelete('cascade');
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
