<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUfcdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_ufcds', function (Blueprint $table) {
            $table->foreignid('course_id')->constrained();
            $table->foreignid('ufcd_id')->constrained();
            $table->timestamps();
            $table->primary(['course_id', 'ufcd_id']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_ufcds');
    }
}
