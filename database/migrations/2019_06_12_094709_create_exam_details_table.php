<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_details', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('fullmarks');
            $table->integer('passmarks');
            $table->integer('practical')->nullable();
            $table->integer('theoritical')->nullable();
            $table->timestamps();
//            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_details');
    }
}
