<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemeriksaansTable extends Migration
{
    public function up()
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->increments('id');

            $table->string('subjektif');

            $table->string('objektif');

            $table->string('penilaian');

            $table->string('plan');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
