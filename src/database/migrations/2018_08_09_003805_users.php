<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            // fields
            $table->increments('id');
            $table->string('full_name', 120);
            $table->string('nickname', 24);
            $table->string('email', 120);
            $table->string('password', 128);
            $table->char('token', 64)->nullable(true);
            $table->boolean('is_email_verified')->default(false);
            $table->timestamps();

            // index
            $table->unique('email');
            $table->unique('nickname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('users');
    }
}
