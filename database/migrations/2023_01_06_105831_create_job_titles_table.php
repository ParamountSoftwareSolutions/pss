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
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('created_by')->nullable()->references('id')->on('users');
            $table->unsignedInteger('status_id')->nullable()->references('id')->on('status');
            $table->timestamps();
        });
        DB::table('job_titles')->insert([
            ['name' => 'Manager'],
            ['name' => 'Accountant'],
            ['name' => 'HR'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_titles');
    }
};
