<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('fee_bill_id');
            $table->integer('dueAmount')->nullable();
            $table->integer('scholarship')->nullable();
            $table->integer('total')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('fee_bill_id')->references('id')->on('fee_bills');
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
        Schema::dropIfExists('fee_details');
    }
}
