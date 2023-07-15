<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('template_name');
            $table->string('background_color')->nullable();
            $table->string('picture_border_color')->nullable();
            $table->string('border_color')->nullable();
            $table->integer('qr_code_size')->nullable();
            $table->integer('image_radius')->nullable();
            $table->integer('logo_size')->nullable();
            $table->string('text_color')->nullable();
            $table->string('template_selected')->nullable();
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
        Schema::dropIfExists('id_template');
    }
}
