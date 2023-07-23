<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donars', function (Blueprint $table) {
             $table->bigIncrements('dr_id');
             $table->integer('fy_id');
             $table->integer('ab_id');
             $table->string('drname',60);
             $table->string('draddress');
             $table->biginteger('drRno');
             $table->date('drRdate');
             $table->char('drGender');
             $table->integer('drmobile');
             $table->char('drDtype');
             $table->char('drAmtype');
             $table->decimal('drAmount',8,2);   
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
        Schema::dropIfExists('donars');
    }
}
