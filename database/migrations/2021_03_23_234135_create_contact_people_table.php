<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('active_client_id');
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_grade')->nullable();
            $table->integer('contact_person_religion')->nullable();
            $table->string('contact_person_photo')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_mobile_phone')->nullable();
            $table->text('contact_person_mobile_email')->nullable();
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
        Schema::dropIfExists('contact_people');
    }
}
