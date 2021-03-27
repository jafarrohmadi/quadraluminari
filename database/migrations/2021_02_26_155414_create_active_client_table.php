<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_client', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('npwp')->nullable();
            $table->text('remark')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('address_country')->nullable();
            $table->string('address_province_id')->nullable();
            $table->string('address_city_id')->nullable();
            $table->text('address_mailing_address')->nullable();
            $table->text('address_postal_code')->nullable();
            $table->text('number_of_students')->nullable();
            $table->text('number_of_lecturers')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('active_client');
    }
}
