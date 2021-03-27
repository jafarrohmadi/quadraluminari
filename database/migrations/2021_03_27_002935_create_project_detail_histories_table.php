<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_detail_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_detail_id');
            $table->bigInteger('active_opportunity_id');
            $table->text('detail_name')->nullable();
            $table->string('detail_qty')->nullable();
            $table->string('detail_value')->nullable();
            $table->text('detail_notes')->nullable();
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
        Schema::dropIfExists('project_detail_histories');
    }
}
