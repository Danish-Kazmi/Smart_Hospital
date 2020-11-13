<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('education')->nullable();
            $table->string('location')->nullable();
            $table->string('skills')->nullable();
            $table->string('notes')->nullable();
            $table->string('user_type')->nullable()->default("admin");
            $table->string('img_path')->nullable()->default("dist/img/avatar5.png");
            $table->integer('fingerprint')->nullable()->unique();
            $table->integer('contactnumber')->nullable();
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
