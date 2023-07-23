<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donees', function (Blueprint $table) {
            $table->increments('donee_id');
            $table->string('fname',20);
            $table->string('mname',20);
            $table->string('lname',20);
            $table->char('gender',1);
            $table->char('m_status',2);
            $table->bigInteger('mobile');
            $table->bigInteger('phone');
            $table->string('email',100);
            $table->string('address');
            $table->timestamps();
            $table->tinyint('district',4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donees');
    }
}
