<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('question_paper_id')->nullable();
            $table->string('name');
            $table->text('questio_code')->nullable();
            $table->text('image')->nullable();
            $table->string('marks')->nullable();
            $table->string('serial_id')->nullable();
            $table->enum('type', ['Multiple Choice', 'True/False', 'Short Answer'])->default('Multiple Choice');
            $table->enum('status', ['Publish', 'Unpublish'])->default('Publish');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('question_paper_id')->references('id')->on('question_papers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
