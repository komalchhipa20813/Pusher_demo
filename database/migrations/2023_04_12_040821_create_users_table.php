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
            $table->tinyInteger('role')->default(2)->comment('1 for admin 2 for user');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('gender')->comment('0 for male 1 for female')->nullable();
            $table->dateTime('dob', $precision = 0)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=Active, 0=DeActive 2=deleted');
            $table->rememberToken();
            $table->timestamps();
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
