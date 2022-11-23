<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cnic')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->unique()->nullable();
            $table->string('alt_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->foreignId('country_id')->unsigned()->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('state_id')->unsigned()->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('city_id')->unsigned()->nullable()->constrained('cities')->nullOnDelete();
            $table->string('dob')->nullable();
            $table->integer('building')->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
