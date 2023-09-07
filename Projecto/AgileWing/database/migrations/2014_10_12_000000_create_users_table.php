<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('color_2')->nullable();
            $table->string('color_1')->nullable();
            $table->foreignid('user_type_id')->constrained();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('token_password');
            
            $table->boolean('token_used');
            $table->date('token_created_at');
            $table->text('notes')->nullable();
            $table->date('last_login');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
