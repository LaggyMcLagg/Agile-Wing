<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_availabilities', function (Blueprint $table) {
            $table->id();
            $table->date('availability_date');
            $table->boolean('is_locked');
            $table->foreignid('user_id')->constrained()->onDelete('cascade');
            $table->foreignid('hour_block_id')->constrained()->onDelete('cascade');
            $table->foreignid('availability_type_id')->constrained();
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
        Schema::dropIfExists('teacher_availabilities');
    }
}