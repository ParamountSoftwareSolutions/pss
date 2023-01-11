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
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('logoweb')->nullable();
            $table->string('favicon')->nullable();
            $table->string('opentime')->nullable();
            $table->string('closetime')->nullable();
            $table->string('vat')->nullable();
            $table->string('isvatnumshow')->nullable();
            $table->string('vattinno')->nullable();
            $table->integer('discount_type')->nullable();
            $table->string('discountrate')->nullable();
            $table->string('servicecharge')->nullable();
            $table->string('service_chargeType')->nullable();
            $table->integer('currency')->nullable();
            $table->string('min_prepare_time')->nullable();
            $table->string('language')->nullable();
            $table->string('timezone')->nullable();
            $table->string('dateformat')->nullable();
            $table->string('site_align')->nullable();
            $table->string('powerbytxt')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('reservation_open')->nullable();
            $table->string('reservation_close')->nullable();
            $table->string('maxreserveperson')->nullable();
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
        Schema::dropIfExists('setting');
    }
};
