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
            $table->text('remark')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_grade')->nullable();
            $table->integer('contact_person_religion')->nullable();
            $table->integer('contact_person_province_id')->nullable();
            $table->integer('contact_person_city_id')->nullable();
            $table->text('contact_person_address')->nullable();
            $table->string('contact_person_photo')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_mobile_phone')->nullable();
            $table->text('contact_person_mobile_email')->nullable();
            $table->text('address_country')->nullable();
            $table->integer('address_province_id')->nullable();
            $table->integer('address_city_id')->nullable();
            $table->text('address_mailing_address')->nullable();
            $table->text('address_postal_code')->nullable();
            $table->text('number_of_students')->nullable();
            $table->text('number_of_lecturers')->nullable();
            $table->integer('status')->default(0);
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
