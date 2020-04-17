<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId("doctor_id");
            $table->json("sat")->default('[]');
            $table->json("sun")->default('[]');
            $table->json("mon")->default('[]');
            $table->json("tues")->default('[]');
            $table->json("wed")->default('[]');
            $table->json("thurs")->default('[]');
            $table->json("fri")->default('[]');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('doctor_schedules');
    }
}