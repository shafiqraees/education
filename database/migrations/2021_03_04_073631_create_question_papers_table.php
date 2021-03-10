<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->text('paper_code')->nullable();
            $table->string('name')->nullable();
            $table->enum('status', ['Publish', 'Unpublish'])->default('Publish');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('question_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('question_papers');
    }
}
