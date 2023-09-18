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
<<<<<<< Updated upstream
            $table->foreignid('course_id')->constrained()->onDelete('cascade');
            $table->foreignid('ufcd_id')->constrained()->onDelete('cascade');
=======
            $table->id();
            $table->foreignid('course_id')->constrained();
            $table->foreignid('ufcd_id')->constrained();
>>>>>>> Stashed changes
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
        Schema::dropIfExists('course_ufcds');
    }
}
