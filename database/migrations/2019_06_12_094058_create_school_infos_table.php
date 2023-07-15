<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('institute_name');
            $table->date('establish_date')->nullable();
            $table->string('address')->nullable();
            $table->string('website_link')->nullable();
            $table->string('email')->nullable();
            $table->string('school_days')->default(180);
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
        Schema::dropIfExists('school_infos');
    }
}
