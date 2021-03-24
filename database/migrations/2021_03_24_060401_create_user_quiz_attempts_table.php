<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQuizAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_paper_id')->nullable();
            $table->unsignedBigInteger('class_room_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('question_option_id')->nullable();
            $table->unsignedBigInteger('launch_quiz_id')->nullable();
            $table->unsignedBigInteger('user_quiz_id')->nullable();
            $table->enum('status', ['Completed', 'Cancellled','Pending'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('question_paper_id')->references('id')->on('question_papers')->onDelete('cascade');
            $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('question_option_id')->references('id')->on('question_options')->onDelete('cascade');
            $table->foreign('launch_quiz_id')->references('id')->on('launch_quizzes')->onDelete('cascade');
            $table->foreign('user_quiz_id')->references('id')->on('user_quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_quiz_attempts');
    }
}
