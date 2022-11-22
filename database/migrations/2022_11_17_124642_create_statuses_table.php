<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
           /* ['new', 'follow_up', 'discussion', 'negotiation', 'lost', 'pending', 'approved', 'rejected', 'arrange_meeting', 'meet_client',
                'mature', 'active', 'cancel', 'suspended','cancelled','transferred','token']*/
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
        Schema::dropIfExists('statuses');
    }
}
