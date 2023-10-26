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
            $table->boolean('published')->default(false);
            $table->foreignid('hour_block_course_class_id')->constrained();
            $table->foreignid('availability_type_id')->constrained();
            $table->foreignid('course_class_id')->constrained()->onDelete('cascade');
            $table->foreignid('ufcd_id')->constrained()->onDelete('cascade');
            $table->foreignid('user_id')->constrained()->onDelete('cascade');
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