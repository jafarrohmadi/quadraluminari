<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveOpportunityRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_opportunity_reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('active_opportunity_id');
            $table->bigInteger('user_id');
            $table->integer('act_history_reminder')->default(1);
            $table->string('act_history_other_name_reminder')->nullable();
            $table->string('act_history_order_reminder')->nullable();
            $table->date('act_history_date_reminder');
            $table->text('act_history_notes_reminder');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_opportunity_reminders');
    }
}
