<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstbregistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estbregistrations', function (Blueprint $table) {
            $table->id();
            $table->string('estbname');
            $table->bigInteger('mobile');
            $table->bigInteger('phone')->nullable();
            $table->string('email');
            $table->string('url');
            $table->string('address');
            $table->smallInteger('register');
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
        Schema::dropIfExists('estbregistrations');
    }
}
