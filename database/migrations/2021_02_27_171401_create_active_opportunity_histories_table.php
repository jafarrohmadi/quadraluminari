<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveOpportunityHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_opportunity_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('active_opportunity_id');
            $table->bigInteger('user_id');
            $table->string('product_name')->nullable();
            $table->integer('act_history')->default(1);
            $table->string('act_history_other_name')->nullable();
            $table->date('act_history_date');
            $table->text('act_history_remarks')->nullable();
            $table->string('opportunity_status')->nullable();
            $table->text('opportunity_status_remarks')->nullable();
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
        Schema::dropIfExists('active_opportunity_histories');
    }
}
