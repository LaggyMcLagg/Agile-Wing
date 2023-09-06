<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHourBlockCourseClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_block_course_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignid('course_class_id')->constrained();
            $table->time('hour_beginning');
            $table->time('hour_end');
            $table->timestamps();
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
        Schema::dropIfExists('hour_block_course_classes');
    }
}
