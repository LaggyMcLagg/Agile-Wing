<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationAreaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialization_area_users', function (Blueprint $table) {
            $table->integer('specialization_area_number');
            $table->foreign('specialization_area_number')
                  ->references('number')
                  ->on('specialization_areas')
                  ->onDelete('cascade');
                  
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
        Schema::dropIfExists('specialization_area_users');
    }
}
