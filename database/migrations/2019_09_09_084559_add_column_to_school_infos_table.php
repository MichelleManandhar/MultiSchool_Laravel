<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSchoolInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_infos', function (Blueprint $table) {
            $table->Integer('acaedemic_year')->nullable();
            $table->string('signature')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('slogan')->nullable();
            $table->string('contact')->nullable();
            $table->Integer('establish_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_infos', function (Blueprint $table) {
            //
        });
    }
}
