<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('subject_id');
            $table->float('theoritical');
            $table->float('practical');
//            $table->integer('thfm');
//            $table->integer('prfm');
            $table->unsignedBigInteger('mark_subject_id')->nullable();
            $table->string('practical_grade')->nullable();
            $table->string('theory_grade')->nullable();
            $table->float('full_percentage')->nullable();
            $table->string('full_grade')->nullable();
            $table->float('full_gpa')->nullable();
            $table->tinyInteger('delete_flag')->default(0);
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('mark_subject_id')->references('id')->on('exam_subjects');
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
        Schema::dropIfExists('marks');
    }
}
