<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->bigInteger('suggested_question_id')->nullable();
            $table->string('name')->nullable();
            $table->string('answer')->nullable();
            $table->text('image')->nullable();
            $table->text('Feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            //$table->foreign('suggested_question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_options');
    }
}
