<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleAtributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_atributions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('hour_start');
            $table->time('hour_end');
            $table->foreignid('availability_type_id')->constrained();
            $table->foreignid('course_class_id')->constrained();
            $table->foreignid('ufcd_id')->constrained();
            $table->foreignid('user_id')->constrained();
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
        Schema::dropIfExists('schedule_atributions');
    }
}
