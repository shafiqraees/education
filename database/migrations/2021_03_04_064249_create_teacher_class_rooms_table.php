<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherClassRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_class_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calss_room_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();
            $table->foreign('calss_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_class_rooms');
    }
}
