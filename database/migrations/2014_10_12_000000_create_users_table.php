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
            $table->string('phone_no');
            $table->string('alternet_phone_no')->nullable();
            $table->date('dob');
            $table->text('residential_address');
            $table->text('office_address')->nullable();
            $table->text('native_address')->nullable();
            $table->text('ohter_office_address')->nullable();
            $table->string('email');
            $table->string('password');
            $table->text('file')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
