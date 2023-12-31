<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamdetailSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examdetail_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('examdetail_id');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('examdetail_id')->references('id')->on('exam_details');
            $table->foreign('subject_id')->references('id')->on('subjects');
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
        Schema::dropIfExists('examdetail_subject');
    }
}
