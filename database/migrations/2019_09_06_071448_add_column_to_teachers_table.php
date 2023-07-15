<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->date('DOB')->nullable();
            $table->string('image_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable()->change();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->boolean('delete_flag')->default(0);
            $table->foreign('school_id')->references('id')->on('school_infos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            //
        });
    }
}
