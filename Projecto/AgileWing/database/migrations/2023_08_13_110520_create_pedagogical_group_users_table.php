<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedagogicalGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedagogical_group_users', function (Blueprint $table) {
            $table->foreignid('pedagogical_group_id')->constrained();
            $table->foreignid('user_id')->constrained();
            $table->timestamps();
            $table->primary(['pedagogical_group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedagogical_group_users');
    }
}
