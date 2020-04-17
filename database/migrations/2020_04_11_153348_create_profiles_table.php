<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('CASCADE');
            $table->string('mobile');
            $table->json('address')->default('{}');
            $table->smallInteger('gender');
            $table->foreignId('category_id')->nullable();
            $table->foreign("category_id")->references('id')->on('doctor_categories')->onDelete('CASCADE');
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
        Schema::dropIfExists('profiles');
    }
}