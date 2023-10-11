<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserUfcdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ufcds', function (Blueprint $table) {
            $table->foreignid('user_id')->constrained()->onDelete('cascade');
            $table->foreignid('ufcd_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'ufcd_id']);
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
        Schema::dropIfExists('user_ufcds');
    }
}
